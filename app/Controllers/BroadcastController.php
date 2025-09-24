<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use Config\Services;

class BroadcastController extends BaseController
{
    // ... (bagian atas controller tidak berubah) ...
    protected $customerModel;

    private $whatsappApiUrl = 'https://wa.jasaawak.com/send-message';
    private $whatsappApiKey = 'OfZd22KyRNNgDdx0TPeGGF1YWgK3LJ';
    private $senderNumber = '6282172754545';

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        helper(['url', 'form']);
    }

    public function index()
    {
        $data = [
            'title'     => 'Broadcast WhatsApp',
            'customers' => $this->customerModel->findAll(),
            'active_menu' => 'broadcast',
        ];
        return view('broadcast/index', $data);
    }

    public function send()
    {
        // ... (fungsi send tidak berubah, logika personalisasi tetap ada
        // dan akan berfungsi jika placeholder {nama_customer} digunakan) ...
        $validation = $this->validate(['template' => 'required', 'customer_ids' => 'required']);
        if (!$validation) {
            return redirect()->back()->withInput()->with('error', 'Pilih template dan setidaknya satu customer.');
        }
        $templateType = $this->request->getPost('template');
        $customMessage = $this->request->getPost('custom_message');
        $customerIds = $this->request->getPost('customer_ids');
        if ($templateType === 'custom' && empty(trim($customMessage))) {
            return redirect()->back()->withInput()->with('error', 'Pesan custom tidak boleh kosong.');
        }
        $customers = $this->customerModel->whereIn('id', $customerIds)->findAll();
        if (empty($customers)) {
            return redirect()->back()->with('error', 'Customer yang dipilih tidak ditemukan.');
        }
        $successCount = 0;
        $failCount = 0;
        foreach ($customers as $customer) {
            $baseMessage = $this->getTemplateMessage($templateType, $customMessage);
            $personalizedMessage = str_replace(
                ['{nama_customer}', '{id_customer}', '{no_hp}'],
                [$customer['nama_customer'], $customer['id_customer'], $customer['no_hp']],
                $baseMessage
            );
            if ($this->sendWhatsAppMessage($customer['no_hp'], $personalizedMessage)) {
                $successCount++;
            } else {
                $failCount++;
            }
            sleep(1);
        }
        $flashMessage = "Broadcast selesai. Berhasil";
        session()->setFlashdata('success', $flashMessage);
        return redirect()->to(base_url('broadcast'));
    }

    // 👇 FUNGSI INI YANG DIPERBAIKI DENGAN TEMPLATE BARU
    private function getTemplateMessage(string $templateType, ?string $customMessage = ''): string
    {
        switch ($templateType) {
            case 'gangguan':
                return "📢 *PENGUMUMAN GANGGUAN LAYANAN INTERNET*\n\n"
                    . "🙏 Kepada seluruh pelanggan setia,\n"
                    . "Kami informasikan bahwa saat ini sedang terjadi *gangguan pada jalur utama jaringan internet*.\n\n"
                    . "⚡ *Status:* Gangguan terdeteksi pada *backbone utama*\n"
                    . "🛠️ *Tindakan:* Saat ini tim teknisi kami sedang melakukan *proses perbaikan* secepat mungkin\n"
                    . "⏳ *Estimasi:* Mohon bersabar, *update progres* perbaikan akan kami informasikan kembali\n\n"
                    . "Kami mohon maaf atas ketidaknyamanan ini dan terima kasih atas pengertian serta kesetiaannya menggunakan layanan kami.\n\n"
                    . "Salam,\n"
                    . "*PT. INDOMEDIA SOLUSI NET*\n";

            case 'normal':
                return "📢 *INFORMASI PEMULIHAN LAYANAN INTERNET*\n\n"
                    . "🙏 Kepada *seluruh pelanggan* setia,\n"
                    . "Kami informasikan bahwa *gangguan pada jalur utama jaringan telah berhasil diperbaiki* dan layanan internet sudah kembali *normal*.\n\n"
                    . "✅ *Status:* Jaringan sudah *normal*\n"
                    . "🛠️ *Tindakan:* Perbaikan *selesai* dilakukan oleh tim teknisi\n"
                    . "🌐 *Layanan:* Dapat digunakan seperti biasa\n\n"
                    . "Terima kasih atas kesabaran dan pengertiannya. Kami akan terus berupaya memberikan layanan terbaik bagi Anda.\n\n"
                    . "Salam,\n"
                    . "*PT. INDOMEDIA SOLUSI NET*";

            case 'tagihan':
                // Saya tambahkan placeholder {nama_customer} agar sapaan lebih personal
                return "📢 *Informasi Tagihan InMeet-Home*\n\n"
                    . "Yth. Bapak/Ibu {nama_customer},\n\n"
                    . "Saat ini tagihan layanan *InMeet-Home* Bapak/Ibu telah *Jatuh Tempo*.\n"
                    . "Mohon segera melakukan pembayaran melalui transfer:\n"
                    . "🏦 *Bank BCA*\n"
                    . "🔢 No. Rekening: *042-6166661*\n"

                    . "👤 a.n. *PT. Indomedia Solusi Net*\n\n"
                    . "⚡ Segera lakukan pembayaran agar layanan internet tetap *Aktif* dan tidak *Terisolir*.\n"
                    . "🙏 Atas perhatian dan kerja samanya, kami ucapkan *terima kasih*.\n\n"
                    . "Hormat kami,\n"
                    . "✍️ *Indomedia Solusi Net*";

            case 'custom':
                return $customMessage;

            default:
                return '';
        }
    }

    // ... (fungsi sendWhatsAppMessage tidak berubah) ...
    private function sendWhatsAppMessage(string $phoneNumber, string $message): bool
    {
        if (empty($phoneNumber) || empty($message)) {
            return false;
        }
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }
        $payload = [
            'api_key' => $this->whatsappApiKey,
            'sender'  => $this->senderNumber,
            'number'  => $phoneNumber,
            'message' => $message,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->whatsappApiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        if ($response === false) {
            log_message('error', 'WhatsApp API cURL Error: ' . $error);
            return false;
        }
        $result = json_decode($response, true);
        if ($httpCode >= 200 && $httpCode < 300 && isset($result['status']) && $result['status'] === 'success') {
            log_message('info', 'Broadcast message sent successfully to ' . $phoneNumber);
            return true;
        } else {
            $logMessage = 'Failed to send broadcast message to ' . $phoneNumber
                . '. HTTP Code: ' . $httpCode
                . '. cURL Error: ' . $error
                . '. Response: ' . $response;
            log_message('error', $logMessage);
            return false;
        }
    }
}
