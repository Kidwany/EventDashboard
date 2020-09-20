<?php
/**
 * Created by PhpStorm.
 * User: Kidwany
 * Date: 1/1/2019
 * Time: 2:27 AM
 */

/*if (!function_exists('setting'))
{
    function setting()
    {
        return \App\Models\Setting::orderBy('id', 'desc')->first();
    }
}*/


if (!function_exists('subCategory'))
{
    function subCategory($parent)
    {
        $subCategories = \Illuminate\Support\Facades\DB::table('sub_categories')->where('category_id', '=', $parent)->get();
        return compact('subCategories');
    }
}




if (!function_exists('lang'))
{
    function lang()
    {
        if (session() -> has('lang'))
        {
            return session('lang');
        }

        else
        {
            return 'en';
        }
    }
}


if (!function_exists('currentLang'))
{
    function currentLang()
    {
        return app()->getLocale();
    }
}



if (!function_exists('direction'))
{
    function direction()
    {
        if (session() -> has('lang'))
        {
            if (session('lang') == 'ar')
            {
                return 'rtl';
            }
            else
            {
                return 'ltr';
            }
        }

        else
        {
            return 'ltr';
        }
    }
}



if (!function_exists('projects'))
{
    function projects()
    {
        $projects = \Illuminate\Support\Facades\DB::table('works')->select('title_en', 'title_nl', 'title_ar', 'id')->limit(5)->get();
    }
}


/*if (!function_exists('defaultLang'))
{
    function defaultLang()
    {
        return  \App\Models\Setting::orderBy('created_at', 'desc')->first();
    }
}*/


if (!function_exists('adminUrl'))
{
    function adminUrl($url = null)
    {
        return  url('/' . $url);
    }
}

if (!function_exists('doctorUrl'))
{
    function doctorUrl($url = null)
    {
        return  url('/tamra-admin/' . $url);
    }
}


if (!function_exists('assetPath'))
{
    function assetPath($path = null)
    {
        return  asset($path);
    }
}

if (!function_exists('uploadedImages'))
{
    function uploadedImagePath()
    {
        return 'dashboardImages';
    }
}



if (!function_exists('ApiWebUrl'))
{
    function ApiWebUrl($url = null)
    {
        return  url('/api/web/auth/' . $url);
    }
}
