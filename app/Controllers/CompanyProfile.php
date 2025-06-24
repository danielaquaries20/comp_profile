<?php

namespace App\Controllers;

class CompanyProfile extends BaseController {
     protected $companySettingsModel;
    protected $serviceModel;
    protected $partnerModel;

    public function __construct()
    {
        $this->companySettingsModel = new \App\Models\CompanySettingsModel();
        $this->serviceModel = new \App\Models\ServiceModel();
        $this->partnerModel = new \App\Models\PartnerModel();
    }

    public function index()
    {        // Get all company settings from database
        $settings = $this->companySettingsModel->getAllSettings();
        $services = $this->serviceModel->getActiveServices();
        $partners = $this->partnerModel->getActivePartners();

        $data = [
            'title' => ($settings['company_name']['value'] ?? 'PT. Samsudi Indoniaga Sedaya') . ' - Solusi Niaga Terpercaya',
            'meta_description' => $settings['company_description']['value'] ?? 'Solusi niaga terpercaya untuk kemajuan bisnis Anda di Indonesia',
            'company_name' => $settings['company_name']['value'] ?? 'PT. Samsudi Indoniaga Sedaya',
            'company_logo' => $settings['company_logo']['value'] ?? '',
            'company_tagline' => $settings['company_tagline']['value'] ?? 'Solusi Niaga Terpercaya di Indonesia',
            'company_description' => $settings['company_description']['value'] ?? 'Membangun kemitraan yang kuat dan memberikan layanan terbaik untuk kemajuan bisnis Anda dengan komitmen tinggi dan profesionalisme.',
            'company_vision' => $settings['company_vision']['value'] ?? 'Menjadi perusahaan terdepan dalam bidang perdagangan yang memberikan solusi inovatif dan berkelanjutan untuk kemajuan ekonomi Indonesia.',
            'company_mission' => $settings['company_mission']['value'] ?? 'Memberikan layanan perdagangan yang berkualitas tinggi, membangun kemitraan strategis, dan berkontribusi positif terhadap pertumbuhan ekonomi nasional melalui praktik bisnis yang etis dan profesional.',
            'hero_background_image' => $settings['hero_background_image']['value'] ?? '',
            'about_image' => $settings['about_image']['value'] ?? '',
            'hero_title' => $settings['hero_title']['value'] ?? 'Solusi Niaga Terpercaya untuk Kemajuan Bisnis Anda',
            'hero_subtitle' => $settings['hero_subtitle']['value'] ?? 'Membangun kemitraan strategis dan memberikan layanan berkualitas tinggi dalam bidang perdagangan untuk mendukung pertumbuhan ekonomi nasional.',
            'services' => $services,
            'partners' => $partners,
            'settings' => $settings,
            'contact_info' => $this->getContactInfo($settings),
            'mapbox_token' => $settings['mapbox_token']['value'] ?? 'pk.eyJ1IjoicGFsb24wMDUiLCJhIjoiY21jMjJ4MDJvMDR0bzJqc2ZtMmxrOW56OSJ9.YFif8g-Il5g5qdynTCXLbA'
        ];

        return view('company/index', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'Tentang Kami - PT. Samsudi Indoniaga Sedaya',
            'company_name' => 'PT. Samsudi Indoniaga Sedaya'
        ];

        return view('company/about', $data);
    }

    public function services()
    {
        $data = [
            'title' => 'Layanan Kami - PT. Samsudi Indoniaga Sedaya',
            'services' => $this->getServices()
        ];

        return view('company/services', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Kontak Kami - PT. Samsudi Indoniaga Sedaya',
            'contact_info' => $this->getContactInfo()
        ];

        return view('company/contact', $data);
    }
    public function submitContact()
    {
        $contactModel = new \App\Models\ContactModel();

        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email',
            'pesan' => 'required|min_length[10]|max_length[1000]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Save contact to database
        $contactData = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'pesan' => $this->request->getPost('pesan'),
            'status' => 'unread'
        ];

        try {
            $contactModel->saveContact($contactData);

            // Optional: Send email notification here
            // $this->sendEmailNotification($contactData);

            return redirect()->to('/#kontak')->with('success', 'Terima kasih! Pesan Anda telah dikirim. Kami akan segera menghubungi Anda.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Maaf, terjadi kesalahan. Silakan coba lagi.');
        }
    }

    private function getContactInfo($settings = [])
    {
        return [
            'address' => $settings['contact_address']['value'] ?? 'Jl. Pemuda No. 123, Semarang<br>Jawa Tengah 50132, Indonesia',
            'phone' => $settings['contact_phone']['value'] ?? '+62 24 1234 5678',
            'email' => $settings['contact_email']['value'] ?? 'info@samsudiindoniaga.co.id',
            'hours' => $settings['contact_hours']['value'] ?? 'Senin - Jumat: 08:00 - 17:00 WIB<br>Sabtu: 08:00 - 12:00 WIB',
            'coordinates' => [
                'lng' => floatval($settings['map_longitude']['value'] ?? 110.4393949),
                'lat' => floatval($settings['map_latitude']['value'] ?? -7.0278497)
            ]
        ];
    }
}