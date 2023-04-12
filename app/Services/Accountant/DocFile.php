<?php

namespace App\Services\Accountant;

use App\Models\File;
use App\Models\Order;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Mpdf\Output\Destination;

abstract class DocFile implements FileInterface
{
    public Provider $provider;
    public array|Collection $orders;
    public int $number;
    public string $format = 'A4';
    public string $fileName = 'file.pdf';
    public string $filePath = '';
    public File $file;
    public Mpdf $mpdf;

    /**
     * @param Provider $provider
     * @param Collection|Order[] $orders
     * @param int $number
     * @throws MpdfException
     */
    public function __construct(Provider $provider, $orders, int $number)
    {
        $this->provider = $provider;
        $this->orders = $orders;
        $this->number = $number;
        $this->mpdf = new Mpdf(
            array(
                'mode' => 'utf-8',
                'format' => $this->format,
            )
        );
        $this->mpdf->SetProtection(array('copy','print'), '', '');
    }

    /**
     * @throws MpdfException
     */
    function createPdf(HtmlForPdfInterface $html) {
        $this->mpdf->WriteHTML('');
    }

    /**
     * @throws MpdfException
     */
    function storage()
    {
        $this->filePath = 'public/bills/'.$this->fileName;
        Storage::put($this->filePath, $this->mpdf->Output('', Destination::STRING_RETURN));
        $this->file = File::create([
            'path'=>env('APP_PATH_FILE_STORE').'bills/'.$this->fileName ,
            'name'=>$this->fileName,
        ]);
    }

    /**
     * @throws MpdfException
     */
    function inline()
    {
        $this->mpdf->Output('', Destination::INLINE);
    }
}
