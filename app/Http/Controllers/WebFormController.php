<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Representatives;
use Illuminate\Http\Request;
use App\Services\YandexCaptchaService;

class WebFormController extends Controller
{
    protected $captchaService;
    
    public function __construct(YandexCaptchaService $captchaService)
    {
        $this->captchaService = $captchaService;
    }

    public function showForm()
    {
        return view('Main_form');
    }
     

    public function submitForm(Request $request)
    {
        if (!$this->captchaService->verify(
            $request->input('smartcaptcha_token'),
        )) {
            return back()
                ->withInput()
                ->withErrors(['smartcaptcha_token' => 'Пройдите проверку "Я не робот"']);
        }

        $organizationData = $request->validate([
            'full_name' => 'required|string|max:255',
            'short_name' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'municipal_district' => 'nullable|string|max:255',
            'region' => 'required|string|max:255',
            'inn' => 'nullable|string|size:10',
            'ogrn' => 'nullable|string|max:15',
            'email' => 'required|email',
            'phone' => 'required|string|regex:/^\d{10}$/',
        ]);

        
        $organization = Organization::create($organizationData);

       
        $repsData = $request->validate([
            'representatives' => 'required|array|min:1',
            'representatives.*.accord' => 'required|in:Согласен,Согласна',
            'representatives.*.name' => 'required|string|max:255',
            'representatives.*.position' => 'required|string|max:255',
            'representatives.*.phone' => 'required|string|regex:/^\d{10}$/',
            'representatives.*.snils' => 'required|string|regex:/^\d{11}$/',
            'representatives.*.email' => 'required|email',
        ]);

        
        foreach ($repsData['representatives'] as $representativeData) {
            Representatives::create([
                'organization_id' => $organization->id,
                'accord' => $representativeData['accord'],
                'name' => $representativeData['name'],
                'position' => $representativeData['position'],
                'phone' => $representativeData['phone'],
                'snils' => $representativeData['snils'],
                'email' => $representativeData['email']
            ]);
        }

        return redirect()->route('form.Success');
    }
}