<?php

namespace App\Http\Controllers;

use App\Models\BasicExtended;
use Illuminate\Support\Facades\Schema;
use App\Models\Language;
use App\Models\User\Language as UserLanguage;
use App\Models\User\UserVcard;
use Illuminate\Http\Request;
use Artisan;
use DB;

class UpdateController extends Controller
{
    public function version()
    {
        return view('updater.version');
    }

    public function recurse_copy($src, $dst)
    {

        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->recurse_copy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    @copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    public function upversion(Request $request)
    {
        $assets = array(
            ['path' => 'assets/admin/js', 'type' => 'folder', 'action' => 'replace'],
            ['path' => 'assets/admin/css', 'type' => 'folder', 'action' => 'replace'],

            ['path' => 'assets/front/css', 'type' => 'folder', 'action' => 'replace'],
            ['path' => 'assets/front/js', 'type' => 'folder', 'action' => 'replace'],
            ['path' => 'assets/front/img', 'type' => 'folder', 'action' => 'add'],

            ['path' => 'core/config', 'type' => 'folder', 'action' => 'replace'],
            ['path' => 'core/database/migrations', 'type' => 'folder', 'action' => 'add'],
            ['path' => 'core/resources/views', 'type' => 'folder', 'action' => 'replace'],
            ['path' => 'core/resources/profile', 'type' => 'folder', 'action' => 'replace'],
            ['path' => 'core/routes/web.php', 'type' => 'file', 'action' => 'replace'],
            ['path' => 'core/app', 'type' => 'folder', 'action' => 'replace'],

            ['path' => 'version.json', 'type' => 'file', 'action' => 'replace']
        );

        foreach ($assets as $key => $asset) {
            // if 'core/resources/views/user/profile' folder exists, only then replace it.
            // otherwise, skip it
            if ($asset['path'] == 'core/resources/profile') {
                $profile = file_exists('core/resources/views/user/profile');
                if ($profile) {
                    @unlink('core/resources/views/user/profile');
                    $this->recurse_copy('updater/' . 'core/resources/profile', 'core/resources/views/user/profile');
                }
                continue;
            }
            // if updater need to replace files / folder (with/without content)
            if ($asset['action'] == 'replace') {
                if ($asset['type'] == 'file') {
                    @copy('updater/' . $asset["path"], $asset["path"]);
                }
                if ($asset['type'] == 'folder') {
                    @unlink($asset["path"]);
                    $this->recurse_copy('updater/' . $asset["path"], $asset["path"]);
                }
            }
            // if updater need to add files / folder (with/without content)
            elseif ($asset['action'] == 'add') {
                if ($asset['type'] == 'folder') {
                    @mkdir($asset["path"] . '/', 0775, true);
                    $this->recurse_copy('updater/' . $asset["path"], $asset["path"]);
                }
            }
        }

        $arr = ['WEBSITE_HOST' => $request->website_host];
        setEnvironmentValue($arr);


        $this->updateLanguage();

        Artisan::call('config:clear');
        // run migration files
        Artisan::call('migrate');

        $langs = UserLanguage::all();
        $newKeys = ["Hi_I'm," => "Hi I'm,","Read_More" => "Read More"];
        foreach ($langs as $key => $lang) {

            $keyArr = json_decode($lang->keywords, true);
            foreach ($newKeys as $key => $newKey) {
                $keyArr["$key"] = $newKey;
            }
            $lang->keywords = json_encode($keyArr);

            $lang->save();
        }


        \Session::flash('success', 'Updated successfully');
        return redirect('updater/success.php');
    }

    function delete_directory($dirname)
    {
        if (is_dir($dirname))
            $dir_handle = opendir($dirname);
        if (!$dir_handle)
            return false;
        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname . "/" . $file))
                    unlink($dirname . "/" . $file);
                else
                    $this->delete_directory($dirname . '/' . $file);
            }
        }
        closedir($dir_handle);
        rmdir($dirname);
        return true;
    }

    public function updateLanguage()
    {
        $langCodes = [];
        $languages = Language::all();
        foreach ($languages as $key => $language) {
            $langCodes[] = $language->code;
        }
        $langCodes[] = 'default';

        foreach ($langCodes as $key => $langCode) {
            // read language json file
            $data = file_get_contents('core/resources/lang/' . $langCode . '.json');

            // decode default json
            $json_arr = json_decode($data, true);


            // new keys
            $newKeywordsJson = file_get_contents('updater/language.json');
            $newKeywords = json_decode($newKeywordsJson, true);
            foreach ($newKeywords as $key => $newKeyword) {
                // # code...
                if (!array_key_exists($key, $json_arr)) {
                    $json_arr[$key] = $key;
                }
            }

            // push the new key-value pairs in language json files
            file_put_contents('core/resources/lang/' . $langCode . '.json', json_encode($json_arr));
        }
    }

    public function redirectToWebsite(Request $request) {
        $arr = ['WEBSITE_HOST' => $request->website_host];
        setEnvironmentValue($arr);
        \Artisan::call('config:clear');

        return redirect()->route('front.index');
    }
}
