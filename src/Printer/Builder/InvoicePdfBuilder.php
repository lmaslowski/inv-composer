<?php
namespace InvoiceBundle\Printer\Builder;


use InvoiceBundle\Printer\InvoicePdfDataContainer;
class InvoicePdfBuilder{

    private $pdf;
    private $invoicePdfDataContainer;
    
    public function __construct($pdf, InvoicePdfDataContainer $invoicePdfAdapter){
        $this->pdf = $pdf;
        $this->invoicePdfDataContainer = $invoicePdfAdapter;
    }

    private function getInvoicePdfDataContainer(){
        return $this->invoicePdfDataContainer;
    }
    
    public function getPdf(){
        return $this->pdf;
    }
    
    public function addPage(){
        $this->getPdf()->AddPage();
    }
    
    public function build(){
        
	 //Logo
        $this->buildLogo();

        //Status
        $this->buildStatus($this->getInvoicePdfDataContainer()->getInvoiceDetails()->getStatus(),  $this->getInvoicePdfDataContainer()->getInvoiceDetails()->getStatusName());
        
        //Sprzedawca
        $status = $this->getInvoicePdfDataContainer()->getInvoiceDetails()->getStatus();
        $seller = 'Sprzedawca';
        $invoicenum = $this->getInvoicePdfDataContainer()->getInvoiceDetails()->getInvoiceNumber();
        $invoicenumLabel = 'Faktura Nr #';
        $datecreated = $this->getInvoicePdfDataContainer()->getInvoiceDetails()->getCreateData();
        $dateCreatedLabel = 'Data wystawienia';
        $duedate = $this->getInvoicePdfDataContainer()->getInvoiceDetails()->getPaymentTerm();
        $dueDateLabel = 'Termin płatnosci';
        
        $firma1kol =  $this->getInvoicePdfDataContainer()->getInvoiceSeller()->getName();
        $firma2kol =  $this->getInvoicePdfDataContainer()->getInvoiceSeller()->getAddress();
        $firma3kol =  $this->getInvoicePdfDataContainer()->getInvoiceSeller()->getPostCode() . ' ' . $this->getInvoicePdfDataContainer()->getInvoiceSeller()->getCity(); 
        $firmaNIP = 'NIP: ' .  $this->getInvoicePdfDataContainer()->getInvoiceSeller()->getNip();
        $nrkontaLabel = 'Numer konta bankowego do wpłaty:';
        $nrKonta = $this->getInvoicePdfDataContainer()->getInvoiceSeller()->getAccountNumber();
        
        $this->buildInvoiceInfo($status, $seller, $invoicenum, $invoicenumLabel, $datecreated, $dateCreatedLabel, $duedate, $dueDateLabel, $firma1kol, $firma2kol, $firma3kol, $firmaNIP, $nrkontaLabel, $nrKonta);

        
        //Nabywca
        $bayerLabel = 'Nabywca';
        $clientIsFirm =  $this->getInvoicePdfDataContainer()->getInvoiceBuyer()->isFirm();
        $clientName =  $this->getInvoicePdfDataContainer()->getInvoiceBuyer()->getName();
        $clientAddress =  $this->getInvoicePdfDataContainer()->getInvoiceBuyer()->getAddress();
        $clientCity =  $this->getInvoicePdfDataContainer()->getInvoiceBuyer()->getCity();
        $clientPostcode =  $this->getInvoicePdfDataContainer()->getInvoiceBuyer()->getPostCode();
        $clientCountry =  $this->getInvoicePdfDataContainer()->getInvoiceBuyer()->getCountryName();
        $clientNip =  $this->getInvoicePdfDataContainer()->getInvoiceBuyer()->getNip();
        $this->buildClientDetails($bayerLabel, $clientName, $clientAddress, $clientCity, $clientPostcode, $clientCountry, $clientNip, $clientIsFirm);

        
        //Lista szczegolow faktury
        $invoiceitemsToShow = $this->getInvoicePdfDataContainer()->getInvoiceDetails()->getInvoiceItems();
        $subtotal = $this->getInvoicePdfDataContainer()->getInvoiceDetails()->getNetPrice(); 
        $tax = $this->getInvoicePdfDataContainer()->getInvoiceDetails()->getTaxPrice();
        $total = $this->getInvoicePdfDataContainer()->getInvoiceDetails()->getGrossPrice();
        $amountByWord = $this->getInvoicePdfDataContainer()->getInvoiceDetails()->getGrossPriceByWord();
        $paymentmethod = $this->getInvoicePdfDataContainer()->getInvoiceDetails()->getPaymentMethodName();
        
	    if($status == 'Unpaid'){
            $termOrPaidDate = 'Termin płatności: ' . $this->getInvoicePdfDataContainer()->getInvoiceDetails()->getPaymentTerm();
        }elseif($status == 'Paid'){
            $termOrPaidDate =  'Data opłacenia: ' . $this->getInvoicePdfDataContainer()->getInvoiceDetails()->getPaymentDate();
        }else{
            $termOrPaidDate = '';
        }
		
        $invoiceStatusLabel = $this->getInvoicePdfDataContainer()->getInvoiceDetails()->getStatusName();
        
        $this->generateTableHeader($status, $invoiceitemsToShow, $subtotal, $tax, $total, $amountByWord, $paymentmethod, $invoiceStatusLabel, $termOrPaidDate);
        
        # Stopka z danymi firmy
        $this->buildFooter('Rejonowy dla Krakowa Śródmieścia Wydział XI Krajowego Rejstru Sądowego, KRS: 0000317766,wysokość kapitału zakładowego 125 000 000 PLN (w całości opłacony), REGON: 120805512, NIP:6751402920.');
    
        return $this->getPdf();
    }

    /**
     * @deprecated
     */
    public function render(){
        $this->getPdf()->output();
    }
    
    private function buildFooter($footer){
        $endpage = $this->getPdf()->getNumPages();
        for ($i = 1; $i <= $endpage; $i++) {
            $this->getPdf()->setPage($i, true);
            $this->getPdf()->SetFont('freesans','',8);
            $this->getPdf()->MultiCell($i == 1 ? 130 : 180, 20, $footer, 0, 'L', 0, 20, '20', 5, true, 0, false, true, 0);
        }
    }
    
    private function buildLogo(){
        if (file_exists(ROOTDIR.'/images/logo.png')){
            $this->getPdf()->Image(ROOTDIR.'/images/logo.png',20,25,75);
        }
        elseif(file_exists(ROOTDIR.'/images/logo.jpg')){
            $this->getPdf()->Image(ROOTDIR.'/images/logo.jpg',20,25,75);
        }
        else{
            $this->getPdf()->Image(ROOTDIR.'/images/placeholder.png',20,25,75);
        }
    }

    private function buildStatus($status, $statusLagresource){
        $statustext =  $statusLagresource;

        $this->getPdf()->SetFillColor(223,85,74);
        $this->getPdf()->SetDrawColor(171,49,43);

        if ($status=="Paid") {
            $this->getPdf()->SetFillColor(151,223,74);
            $this->getPdf()->SetDrawColor(110,192,70);
        }elseif ($status=="Cancelled") {
            $this->getPdf()->SetFillColor(200);
            $this->getPdf()->SetDrawColor(140);
        } elseif ($status=="Refunded") {
            $this->getPdf()->SetFillColor(131,182,218);
            $this->getPdf()->SetDrawColor(91,136,182);
        } elseif ($status=="Collections") {
            $this->getPdf()->SetFillColor(3,3,2);
            $this->getPdf()->SetDrawColor(127);
        }

        $this->getPdf()->SetXY(0,0);
        $this->getPdf()->SetFont('freesans','B',16);
        $this->getPdf()->SetTextColor(255);
        $this->getPdf()->SetLineWidth(0.75);
        $this->getPdf()->StartTransform();
        $this->getPdf()->Rotate(-35,100,225);
        $this->getPdf()->Cell(100,18,strtoupper($statustext),'TB',0,'C','1');
        $this->getPdf()->StopTransform();
        $this->getPdf()->SetTextColor(0);
    }

    private function buildInvoiceInfo(
            $status,
            $seller,
            $invoicenum, $invoicenumLabel,
            $datecreated, $dateCreatedLabel,
            $duedate, $dueDateLabel,
            $firma1kol, $firma2kol, $firma3kol, $firmaNIP,
            $nrkontaLabel,$nrKonta
    ){
        $this->getPdf()->SetFont('freesans','B',15);
        $this->getPdf()->SetFillColor(239);
        $this->getPdf()->MultiCell(90,8,$seller,0,'L', 0, 2,'15', '70', true, 0, false, true, 0);
        $this->getPdf()->MultiCell(90,8,$invoicenumLabel . $invoicenum,0,'R', 0, 2,'100', '70', true, 0, false, true, 0);
        $this->getPdf()->SetFont('freesans','',10);
        $this->getPdf()->MultiCell(90,8, $dateCreatedLabel.': '.$datecreated.'',0,'R', 0, 2,'100', '80', true, 0, false, true, 0);
        if ($status =="Unpaid") {
            $this->getPdf()->MultiCell(90,8,$dueDateLabel.': '.$duedate.'',0,'R', 0, 2,'100', '85', true, 0, false, true, 0);
        }

        $this->getPdf()->MultiCell(90,8,$firma1kol,0,'L', 0, 2,'15', '80', true, 0, false, true, 0);
        $this->getPdf()->MultiCell(90,8,$firma2kol,0,'L', 0, 2,'15', '85', true, 0, false, true, 0);
        $this->getPdf()->MultiCell(90,8,$firma3kol,0,'L', 0, 2,'15', '90', true, 0, false, true, 0);
        $this->getPdf()->MultiCell(90,8,$firmaNIP,0,'L', 0, 2,'15', '95', true, 0, false, true, 0);
        $this->getPdf()->SetFont('freesans','',10);

        # Numer konta do wpłaty; tylko dla proform!
        if ($status=="Unpaid")
        {
            $this->getPdf()->MultiCell(90,8,$nrkontaLabel,0,'L', 0, 2,'15', '100', true, 0, false, true, 0);
            $this->getPdf()->MultiCell(90,8,$nrKonta,0,'L', 0, 2,'73', '100', true, 0, false, true, 0);
        }
        
        $this->getPdf()->Ln(10);
        $startpage = $this->getPdf()->GetPage();
        $addressypos = $this->getPdf()->GetY();
    }


    private function buildClientDetails($bayerLabel, $clientName, $clientAddress, $clientCity, $clientPostcode, $clientCountry, $clientNip)
    {
        $this->getPdf()->SetFont('freesans','B',15);
        $this->getPdf()->MultiCell(90,8,$bayerLabel,0,'L', 0, 2,'15', '115', true, 0, false, true, 0);
        $this->getPdf()->SetFont('freesans','',10);
        $this->getPdf()->MultiCell(90,8,$clientName,0,'L', 0, 2,'15', '125', true, 0, false, true, 0);
        $this->getPdf()->MultiCell(90,8,$clientAddress,0,'L', 0, 2,'15', '130', true, 0, false, true, 0);
        $this->getPdf()->MultiCell(90,8,$clientPostcode . ' ' . $clientCity ,0,'L', 0, 2,'15', '135', true, 0, false, true, 0);
        $this->getPdf()->MultiCell(90,8,$clientCountry ,0,'L', 0, 2,'15', '140', true, 0, false, true, 0);
        
        if ($clientNip != null)  {
            $this->getPdf()->MultiCell(90,8,"Nip: ".$clientNip,0,'L', 0, 2,'15', '145', true, 0, false, true, 0);
        } 
        
        
    }
    
    private function generateTableHeader($status,
                                        $invoiceitemsToShow, 
                                        $subtotal, 
                                        $tax, 
                                        $total, 
                                        $amountByWord, 
                                        $paymentmethod, 
                                        $invoiceStatusLabel, 
                                        $termOrPaidDate){
        
        $tblhtml = '<table width="100%" bgcolor="#000" cellspacing="1" cellpadding="2" border="1" >
                        <tr height="30" bgcolor="#fff" style="font-weight:bold;text-align:center;">
                            <td width="45%">Nazwa towaru/usługi</td>
                            <td width="6%">J.m.</td>
                            <td width="6%">Ilość</td>
                            <td width="10%">Cena j.netto [zł]</td>
                            <td width="10%">Wartość netto [zł]</td>
                            <td width="5%">VAT [%]</td>
                            <td width="10%">Kwota podatku [zł]</td>
                            <td width="10%">Wartość brutto [zł]</td>
                        </tr>';

        
        foreach ($invoiceitemsToShow AS $invoiceDetailWrapper) {
            $tblhtml .= '
                <tr bgcolor="#fff">
                    <td align="left">'.nl2br($invoiceDetailWrapper->getDescription()).'<br /></td>
                    <td align="right">usł.</td>
                    <td align="right">'.$invoiceDetailWrapper->getCount().'</td>
                    <td align="right">'.$invoiceDetailWrapper->getUnitNettoPrice().'</td>
                    <td align="center">'.$invoiceDetailWrapper->getNetPrice().'</td>
                    <td align="right">'.$invoiceDetailWrapper->getTaxRate().'</td>
                    <td align="right">'.$invoiceDetailWrapper->getTaxPrice().'</td>
                    <td align="right">'.$invoiceDetailWrapper->getGrossPrice().'</td>
                </tr>';
        }
        
        $tblhtml .= '
            <tr bgcolor="#fff">
                <td colspan="4" align="right">Razem:</td>
                <td align="center">'.($subtotal).'</td>
                <td align="right">x</td>
                <td align="right">'.($tax).'</td>
                <td align="right">'.($total).'</td>
            </tr>
        ';
        $tblhtml .= '</table>';
        
            $tblhtml .= '
            <table table width="100%" border="0">
                <tr bgcolor="#fff" >
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                </tr>
                <tr bgcolor="#fff" >
                    <td align="left">Do zapłaty: <b>'.($total).' zł</b></td>
                    <td align="right">Sposób zapłaty: '.$paymentmethod.'</td>
                </tr>
                    <tr bgcolor="#fff" >
                    <td align="left">&nbsp;</td>
                    <td align="right">'.$termOrPaidDate.'</td>
                </tr>
                    <tr bgcolor="#fff" >
                    <td align="left">Słownie: ' . $amountByWord . '</td> 
                    <td align="right">Faktura '.  $invoiceStatusLabel.'</td>
                </tr>
            </table>';
        
        $tblhtml .= '
        <table table width="100%" border="0">
            <tr bgcolor="#fff" >
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
            </tr>
            <tr bgcolor="#fff" >
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
            </tr>
            <tr bgcolor="#fff" >
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
            </tr>
            <tr bgcolor="#fff" >
                <td align="center">&nbsp;</td>
                <td align="center">Sebastian Pacanek</td>
            </tr>
            <tr bgcolor="#fff">
                <td align="center">.....................................................................</td>
                <td align="center">.....................................................................</td>
            </tr>
            <tr bgcolor="#fff">
                <td align="center">Osoba upoważniona do odbioru</td>
                <td align="center">Osoba upoważniona do wystawienia</td>
            </tr>
        </table>
        ';
        $this->getPdf()->SetFont('freesans','B',15);
        $this->getPdf()->MultiCell(90,8,'Przedpłata za usługi:' ,0,'L', 0, 2,'15', '155', true, 0, false, true, 0);
        $this->getPdf()->SetFont('freesans','',9);

        $this->getPdf()->Ln(5);
        $this->getPdf()->writeHTML($tblhtml, true, false, false, false, '');
        $this->getPdf()->Ln(10);
    }
    
    

}
