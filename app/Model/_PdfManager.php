<?php
declare(strict_types=1);
namespace App\Model;

use Nette;
use Nette\Security\User;


class PdfManager
{
    use Nette\SmartObject;
    
    /** @string */
    private $reportHeader;
    
    /** @string */
    private $reportContent;
    
    /** @string */
    private $reportFooter;
    
    /** @var Nette\Database\Context */
    private $database;
    
    /** @var \Nette\Security\User */
    private $user;
    
    
    public function __construct(Nette\Database\Context $database,
                                User $user) {
            $this->user = $user->getIdentity();
            $this->database = $database;
    }
    
    /**
     * Define PDF header
     * @return string
     */
    public function getHeader() {
        
        $this->reportHeader = '<p>Header</p>';
    
        return $this->reportHeader;
        
    }
    
    /**
     * Define PDF footer
     * @return string
     */
    public function getFooter() {
        
        $detail = (!empty($this->user->print_detail) && $this->user->print_detail == "ANO" ? $this->user->company_name . ', ' . $this->user->address . ', ' . $this->user->ico : 'Vidia spol s.r.o, Nad Safinou II, Vestec');
        
        $this->reportFooter = '<p>Strana/Page {PAGENO} z {nb}</p>';
        
        return $this->reportFooter;
        
    }
    

    /**
     * Define PDF content
     * @param type $value
     * @return string
     */
    public function getContent($value)
    {
        
        /** content */
        $this->reportContent = '<p>Content...</p>';
        
        return $this->reportContent;
    }
    
    
    /**
     * PDF report via mPDF library
     * @param type $value
     */
    public function pdfReport($value)
    {

        /** page settings */
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 10,
            'margin_header' => 5,
            'margin_footer' => 5
        ]);
        $mpdf->SetDisplayMode('fullpage');

        /** set header and footer */
        $mpdf->SetHTMLHeader($this->getHeader());
        $mpdf->SetHTMLFooter($this->getFooter());

        /*
         * Set final content 
         */
        // load a stylesheet
        $stylesheet = file_get_contents('./css/pdf.css');
        $mpdf->WriteHTML($stylesheet, 1);       // The parameter 1 tells that this is css/style only and no body/html/text

        // create final PDF content and file name
        $mpdf->WriteHTML($this->getContent($value), 2);
        $mpdf->Output('Filename_'. date("Ymd_His", time()) .'.pdf','I');

    }
}