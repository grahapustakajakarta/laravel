<?php

namespace App\Services;

use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Log;

class PdfPreviewService
{
    /**
     * Memotong PDF menjadi N halaman pertama untuk preview.
     *
     * @param string $sourcePath Path absolut ke file PDF sumber.
     * @param string $outputPath Path absolut ke file PDF hasil.
     * @param int $pagesToExtract Jumlah halaman pertama yang akan diambil.
     * @return bool True jika berhasil, False jika gagal.
     */
    public static function generatePreview($sourcePath, $outputPath, $pagesToExtract = 10)
    {
        if (!file_exists($sourcePath)) {
            Log::error("PdfPreviewService: File sumber tidak ditemukan - " . $sourcePath);
            return false;
        }

        try {
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($sourcePath);

            $pagesToExtract = min($pageCount, $pagesToExtract);

            for ($pageNo = 1; $pageNo <= $pagesToExtract; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                
                // Dapatkan ukuran asli halaman
                $size = $pdf->getTemplateSize($templateId);
                
                // Tambahkan halaman dengan orientasi dan ukuran yang sesuai
                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                
                // Gunakan template
                $pdf->useTemplate($templateId);
            }

            $pdf->Output($outputPath, 'F');
            return true;
            
        } catch (\Exception $e) {
            Log::error("PdfPreviewService gagal membuat preview: " . $e->getMessage());
            return false;
        }
    }
}
