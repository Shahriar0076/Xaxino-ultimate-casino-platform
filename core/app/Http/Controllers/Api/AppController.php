<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Page;
use App\Models\Frontend;
use App\Models\Language;
use App\Constants\Status;
use App\Models\Extension;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\AdminNotification;
use App\Http\Controllers\Controller;
use App\Traits\SupportTicketManager;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class AppController extends Controller
{
    use SupportTicketManager;

    public function __construct()
    {
        $this->userType     = 'user';
        $this->column       = 'user_id';
        $this->user = auth()->user();
        $this->apiRequest = true;
    }

    public function generalSetting()
    {
        $notify[] = 'General setting data';
        $data = [
            'general_setting' => gs()->only(
                'site_name',
                'cur_text',
                'cur_sym',
                'base_color',
                'secondary_color',
                'kv',
                'ev',
                'maintenance_mode',
                'secure_password',
                'agree',
                'multi_language',
                'registration',
                'active_template',
                'paginate_number',
                'system_customized',
                'currency_format'
            ),
            'social_login_redirect' => route('user.social.login.callback', ''),
        ];

        return responseSuccess('general_setting', $notify, $data);
    }

    public function getCountries()
    {
        $countryData = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $notify[]    = 'Country List';
        foreach ($countryData as $k => $country) {
            $countries[] = [
                'country'      => $country->country,
                'dial_code'    => $country->dial_code,
                'country_code' => $k,
            ];
        }

        return responseSuccess('country_data', $notify, [
            'countries' => $countries
        ]);
    }

    public function getLanguage($code = null)
    {
        $languages     = Language::get();
        $languageCodes = $languages->pluck('code')->toArray();

        if (($code && !in_array($code, $languageCodes))) {
            $notify[] = 'Invalid code given';
            return responseError('validation_error',$notify);
        }

        if (!$code) {
            $code = Language::where('is_default', Status::YES)->first()?->code ?? 'en';
        }

        $jsonFile = file_get_contents(resource_path('lang/' . $code . '.json'));

        $notify[] = 'Language';
        return responseSuccess('language', $notify, [
            'languages' => $languages,
            'file' => json_decode($jsonFile) ?? [],
            'code' => $code,
            'image_path' => getFilePath('language')
        ]);
    }

    public function policies()
    {
        $policies = getContent('policy_pages.element', orderById: true);
        $notify[] = 'All policies';
        return responseSuccess('policy_data', $notify, [
            'policies' => $policies,
        ]);
    }

    public function policyContent($slug)
    {
        $policy = Frontend::where('slug', $slug)->where('data_keys', 'policy_pages.element')->first();
        if (!$policy) {
            $notify[] = 'Policy not found';
            return responseError('policy_not_found', $notify);
        }

        $seoContents = $policy?->seo_content;
        $seoImage = $seoContents->image ? frontendImage('policy_pages', $seoContents->image, getFileSize('seo'), true) : null;
        $notify[] = 'Policy content';

        return responseSuccess('policy_content', $notify, [
            'policy' => $policy,
            'seo_content' => $seoContents,
            'seo_image' => $seoImage
        ]);
    }

    public function faq()
    {
        $faq      = getContent('faq.element', orderById: true);
        $notify[] = 'FAQ';
        return responseSuccess('faq', $notify, ['faq' => $faq]);
    }

    public function seo()
    {
        $notify[] = 'Global SEO data';
        $seo = Frontend::where('data_keys', 'seo.data')->first();
        return responseSuccess('seo', $notify, ['seo_content' => $seo]);
    }

    public function getExtension($act)
    {
        $notify[] = 'Extension Data';
        $extension = Extension::where('status', Status::ENABLE)->where('act', $act)->first()?->makeVisible('shortcode');
        return responseSuccess('extension', $notify, [
            'extension' => $extension,
            'custom_captcha' => $act == 'custom-captcha' ? loadCustomCaptcha() : null
        ]);
    }

    public function submitContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors());
        }

        if (!verifyCaptcha()) {
            $notify[] = 'Invalid captcha provided';
            return responseError('captcha_error', $notify);
        }

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = Status::PRIORITY_MEDIUM;

        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = Status::TICKET_OPEN;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = 0;
        $adminNotification->title = 'A new contact message has been submitted';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = 'Contact form submitted successfully';
        return responseSuccess('contact_form_submitted', $notify, ['ticket' => $ticket]);
    }

    public function cookie()
    {
        $cookie = Frontend::where('data_keys', 'cookie.data')->first();
        $notify[] = 'Cookie policy';

        return responseSuccess('cookie_data', $notify, [
            'cookie' => $cookie
        ]);
    }

    public function cookieAccept()
    {
        Cookie::queue('gdpr_cookie', gs('site_name'), 43200);
        $notify[] = 'Cookie accepted';

        return responseSuccess('cookie_accepted', $notify);
    }

    public function customPages()
    {
        $pages = Page::where('tempname', activeTemplate())
            ->where(function ($query) {
                $query->where('is_default', Status::NO)->orWhere('slug', '/'); // home page data went with default
            })
            ->get();

        $notify[] = 'Custom pages';
        return responseSuccess('custom_pages', $notify, [
            'pages' => $pages
        ]);
    }


    public function customPageData($slug)
    {
        if ($slug == 'home') $slug = '/';

        // default is home page, the where clause for default page is removed
        $page = Page::where('tempname', activeTemplate())->where('slug', $slug)->first();
        if (!$page) {
            $notify[] = 'Page not found';
            return responseError('page_not_found', $notify);
        }

        $seoContents = $page->seo_content;
        $seoImage = $seoContents?->image ? getImage(getFilePath('seo') . '/' . $seoContents?->image, getFileSize('seo')) : null;
        $notify[] = 'Custom page';
        return responseSuccess('custom_page', $notify, [
            'page' => $page,
            'seo_content' => $seoContents,
            'seo_image' => $seoImage
        ]);
    }

    public function allSections($key = null)
    {
        $items = Frontend::where('data_keys', 'like', '%.content')
            ->orWhere('data_keys', 'like', '%.element')
            ->orWhere('data_keys', 'like', '%.data')
            ->get();

        $groupedItems = $items->groupBy(function ($item) {
            return explode('.', $item->data_keys)[0]; // Group by section key
        });

        $data = $groupedItems->map(function ($group, $sectionKey) {
            $content   = $group->firstWhere('data_keys', "{$sectionKey}.content");
            $elements  = $group->filter(fn($item) => str_ends_with($item->data_keys, '.element'));
            $dataItems = $group->filter(fn($item) => str_ends_with($item->data_keys, '.data'));

            return [
                'key'      => $sectionKey,
                'content'  => $content->data_values ?? null,
                'elements' => $elements->pluck('data_values')->toArray(),
                'data'     => $dataItems->pluck('data_values')->first(),
            ];
        })->values();

        return $key ? $data->firstWhere('key', $key) : $data;
    }
}
