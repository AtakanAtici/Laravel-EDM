<?php

namespace AtakanAtici\EDM\Classes;

use App\Models\Tenant;

class Fatura
{
    const UBL_VERSION_ID = '2.1';

    const CUSTOMIZATION_ID = 'TR1.2';

    const COPY_INDICATOR = 'false';

    private $profile_id;

    private $id = '';

    private $uuid;

    private $issue_date;

    private $issue_time;

    private $invoice_type_code;

    private $note = [];

    private $document_currency_code;

    private $line_count_numeric;

    private $satirlar = [];

    private $additionalDocumentReference = [];

    private $irsaliye = [];

    private $teslimat = null;

    private $odemeTip = null;

    private $vergi = null;

    private $iskontoArttirim = null;

    private $satirToplam = 0.0; //Satırdaki Ürünlerin Birim Fiyat * Miktar Toplamı

    private $vergiHaricToplam = 0.0; //Vergiler Hariç İskontolar Eklenmiş Tutar

    private $vergiDahilToplam = 0.0; //Vergiler Dahil Tutar İskontolar Eklenmiş

    private $toplamIskonto = 0.0; //Toplam İskonto Tutarı

    private $yuvarlamaTutar = 0.0; //Yuvarlama Varsa Yuvarlama Tutarı

    private $odenecekTutar = 0.0; //Faturanın Dip Toplamı. Ödenecek Tutar

    /**
     * @var Cari
     */
    private $duzenleyen;

    /**
     * @var Cari
     */
    private $alici;

    /**
     * @return string
     */
    public function getProfileId()
    {
        return $this->profile_id;
    }

    /**
     * @param  string  $profile_id
     */
    public function setProfileId($profile_id)
    {
        $this->profile_id = $profile_id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param  mixed  $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param  string  $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return mixed
     */
    public function getIssueDate()
    {
        return $this->issue_date;
    }

    /**
     * @param  string  $issue_date
     */
    public function setIssueDate($issue_date)
    {
        $this->issue_date = $issue_date;
    }

    /**
     * @return string
     */
    public function getIssueTime()
    {
        return $this->issue_time;
    }

    /**
     * @param  string  $issue_time
     */
    public function setIssueTime($issue_time)
    {
        $this->issue_time = $issue_time;
    }

    /**
     * @return string
     */
    public function getInvoiceTypeCode()
    {
        return $this->invoice_type_code;
    }

    /**
     * @param  string  $invoice_type_code
     */
    public function setInvoiceTypeCode($invoice_type_code)
    {
        $this->invoice_type_code = $invoice_type_code;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param  string  $note
     */
    public function setNote($note)
    {
        $this->note[] = $note;
    }

    /**
     * @return mixed
     */
    public function getDocumentCurrencyCode()
    {
        return $this->document_currency_code;
    }

    /**
     * @param  mixed  $document_currency_code
     */
    public function setDocumentCurrencyCode($document_currency_code)
    {
        $this->document_currency_code = $document_currency_code;
    }

    /**
     * @return mixed
     */
    public function getLineCountNumeric()
    {
        return $this->line_count_numeric;
    }

    /**
     * @param  mixed  $line_count_numeric
     */
    public function setLineCountNumeric($line_count_numeric)
    {
        $this->line_count_numeric = $line_count_numeric;
    }

    /**
     * @return Cari
     */
    public function getDuzenleyen()
    {
        return $this->duzenleyen;
    }

    public function setDuzenleyen(Cari $duzenleyen)
    {
        $duzenleyen->setPozisyon('GONDEREN');
        $this->duzenleyen = $duzenleyen;
    }

    /**
     * @return Cari
     */
    public function getAlici()
    {
        return $this->alici;
    }

    public function setAlici(Cari $alici)
    {
        $alici->setPozisyon('ALICI');
        $this->alici = $alici;
    }

    /**
     * @return float
     */
    public function getSatirToplam()
    {
        return $this->satirToplam;
    }

    /**
     * @param  float  $satirToplam
     */
    public function setSatirToplam($satirToplam)
    {
        $this->satirToplam = $satirToplam;
    }

    /**
     * @return float
     */
    public function getVergiHaricToplam()
    {
        return $this->vergiHaricToplam;
    }

    /**
     * @param  float  $vergiHaricToplam
     */
    public function setVergiHaricToplam($vergiHaricToplam)
    {
        $this->vergiHaricToplam = $vergiHaricToplam;
    }

    /**
     * @return float
     */
    public function getVergiDahilToplam()
    {
        return $this->vergiDahilToplam;
    }

    /**
     * @param  float  $vergiDahilToplam
     */
    public function setVergiDahilToplam($vergiDahilToplam)
    {
        $this->vergiDahilToplam = $vergiDahilToplam;
    }

    /**
     * @return float
     */
    public function getToplamIskonto()
    {
        return $this->toplamIskonto;
    }

    /**
     * @param  float  $toplamIskonto
     */
    public function setToplamIskonto($toplamIskonto)
    {
        $this->toplamIskonto = $toplamIskonto;
    }

    /**
     * @return float
     */
    public function getYuvarlamaTutar()
    {
        return $this->yuvarlamaTutar;
    }

    /**
     * @param  float  $yuvarlamaTutar
     */
    public function setYuvarlamaTutar($yuvarlamaTutar)
    {
        $this->yuvarlamaTutar = $yuvarlamaTutar;
    }

    /**
     * @return float
     */
    public function getOdenecekTutar()
    {
        return $this->odenecekTutar;
    }

    /**
     * @param  float  $odenecekTutar
     */
    public function setOdenecekTutar($odenecekTutar)
    {
        $this->odenecekTutar = $odenecekTutar;
    }

    /**
     * @return array
     */
    public function getVergi()
    {
        return $this->vergi;
    }

    /**
     * @param  array  $vergi_toplam
     */
    public function setVergi($vergi_toplam)
    {
        $this->vergi = $vergi_toplam;
    }

    /**
     * @return null
     */
    public function getIskontoArttirim()
    {
        return $this->iskontoArttirim;
    }

    /**
     * @param  null  $iskontoArttirim
     */
    public function setIskontoArttirim(IskontoArttirim $iskontoArttirim)
    {
        $this->iskontoArttirim = $iskontoArttirim;
    }

    /**
     * @return array
     */
    public function getSatirlar()
    {
        return $this->satirlar;
    }

    public function addIrsaliye(Irsaliye $irs)
    {
        $this->irsaliye[] = $irs;
    }

    /**
     * @return null
     */
    public function getTeslimat()
    {
        return $this->teslimat;
    }

    /**
     * @param  null  $teslimat
     */
    public function setTeslimat(Teslimat $teslimat)
    {
        $this->teslimat = $teslimat;
    }

    /**
     * @return null
     */
    public function getOdemeTip()
    {
        return $this->odemeTip;
    }

    /**
     * @param  null  $odemeTip
     */
    public function setOdemeTip(OdemeSekli $odemeTip)
    {
        $this->odemeTip = $odemeTip;
    }

    /**
     * @param  array  $satirlar
     */
    public function addSatir(Satir $satir)
    {
        $satir->setParaBirimKod($this->getDocumentCurrencyCode());
        $this->satirlar[] = $satir;
    }

    /**
     * @return array
     */
    public function getAdditionalDocumentReference()
    {
        return $this->additionalDocumentReference;
    }

    public function withholding()
    {
        if($this->getSatirToplam() >= Tenant::first()->tevkifat_min_limit){
            return true;
        }
        return false;
    }

    /**
     * @param  array  $additionalDocumentReference
     */
    public function setAdditionalDocumentReference($additionalDocumentReference)
    {
        $this->additionalDocumentReference = $additionalDocumentReference;
    }

    public function readXML()
    {
        $xmlStr = '<Invoice ';
        $xmlStr .= 'xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" ';
        $xmlStr .= 'xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" ';
        $xmlStr .= 'xmlns:xades="http://uri.etsi.org/01903/v1.3.2#" ';
        $xmlStr .= 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ';
        $xmlStr .= 'xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" ';
        $xmlStr .= 'xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xsi:schemaLocation="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2 UBL-Invoice-2.1.xsd" ';
        $xmlStr .= 'xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2">';
        $xmlStr .= '<ext:UBLExtensions><ext:UBLExtension><ext:ExtensionContent /></ext:UBLExtension></ext:UBLExtensions>';
        $xmlStr .= '<cbc:UBLVersionID>'.self::UBL_VERSION_ID.'</cbc:UBLVersionID>';
        $xmlStr .= '<cbc:CustomizationID>'.self::CUSTOMIZATION_ID.'</cbc:CustomizationID>';
        $xmlStr .= '<cbc:ProfileID>'.$this->getProfileId().'</cbc:ProfileID>';
        if ($this->getId() != '') {
            $xmlStr .= '<cbc:ID>'.$this->getId().'</cbc:ID>';
        } else {
            $xmlStr .= '<cbc:ID />';
        }
        $xmlStr .= '<cbc:CopyIndicator>'.self::COPY_INDICATOR.'</cbc:CopyIndicator>';
        $xmlStr .= '<cbc:UUID>'.$this->getUuid().'</cbc:UUID>';
        $xmlStr .= '<cbc:IssueDate>'.$this->getIssueDate().'</cbc:IssueDate>';
        $xmlStr .= '<cbc:IssueTime>'.$this->getIssueTime().'</cbc:IssueTime>';
        $xmlStr .= '<cbc:InvoiceTypeCode>'.$this->getInvoiceTypeCode().'</cbc:InvoiceTypeCode>';
        if (count($this->getNote()) > 0) {
            $listNote = $this->getNote();
            foreach ($listNote as $k => $v) {
                $xmlStr .= '<cbc:Note>'.$v.'</cbc:Note>';
            }
        }
        $xmlStr .= '<cbc:DocumentCurrencyCode>'.$this->getDocumentCurrencyCode().'</cbc:DocumentCurrencyCode>';
        $xmlStr .= '<cbc:LineCountNumeric>'.$this->getLineCountNumeric().'</cbc:LineCountNumeric>';
        //İrsaliye Varsa Irsaliye Bilgisi Ekleniyor
        if (count($this->irsaliye) > 0) {
            foreach ($this->irsaliye as $irs) {
                $xmlStr .= $irs->readXML();
            }
        }
        //Düzenleyen bilgisi eklendi
        $xmlStr .= $this->getDuzenleyen()->readXML();
        //Alıcı Bilgisi Eklendi
        $xmlStr .= $this->getAlici()->readXML();
        //Teslimat Bilgileri Varsa Ekleniyor
        if ($this->getTeslimat() != null) {
            $this->getTeslimat()->setUlkeKod($this->getDuzenleyen()->getUlkeKod());
            $this->getTeslimat()->setUlkeAd($this->getDuzenleyen()->getUlkeAd());
            $xmlStr .= $this->getTeslimat()->readXML();
        }
        //Ödeme Tipi Bilgileri Ekleniyor
        if ($this->getOdemeTip() != null) {
            $xmlStr .= $this->getOdemeTip()->readXML();
        }
        /*Dip Toplamdaki Vergiler Okunuyor*/
        $lines = $this->getSatirlar();
        if (count($lines) > 0) {
            $_lineTaxTotals = [];
            foreach ($lines as $sno => $satir) {
                if (! isset($satir->getVergi()->getVergiOran()[1])) {
                    dd($satir);
                }
                if (array_key_exists($satir->getVergi()->getVergiOran()[1], $_lineTaxTotals)) {
                    $_lineTaxTotals[$satir->getVergi()->getVergiOran()[1]] += $satir->getVergi()->getVergiTutar();
                } else {
                    $_lineTaxTotals[$satir->getVergi()->getVergiOran()[1]] = $satir->getVergi()->getVergiTutar();
                }
            }
            foreach ($_lineTaxTotals as $taxRate => $lineTaxTotal) {
                $satir_vergi = new Vergi();
                $satir_vergi->setSiraNo(1);
                $satir_vergi->setVergiHaricTutar(0);
                $satir_vergi->setVergiTutar($lineTaxTotal);
                $satir_vergi->setParaBirimKod('TRY');
                $satir_vergi->setVergiOran($taxRate);
                $satir_vergi->setVergiKod('0015');
                $satir_vergi->setVergiAd('KDV GERCEK');
                $xmlStr .= $satir_vergi->readXML();
            }
        }
        if($this->withholding()){
            $xmlStr .= '<cac:WithholdingTaxTotal>';
            $xmlStr .= '<cbc:TaxAmount currencyID="TRY">20.25</cbc:TaxAmount>';
            $xmlStr .= '<cac:TaxSubtotal>';
            $xmlStr .=	'<cbc:TaxableAmount currencyID="TRY">22.5</cbc:TaxableAmount>';
            $xmlStr .= '	<cbc:TaxAmount currencyID="TRY">20.25</cbc:TaxAmount>';
            $xmlStr .= '	<cbc:CalculationSequenceNumeric>1</cbc:CalculationSequenceNumeric>';
            $xmlStr .= '	<cbc:Percent>90</cbc:Percent>';
            $xmlStr .= '	<cac:TaxCategory>';
            $xmlStr .= '		<cac:TaxScheme>';
            $xmlStr .= '<cbc:Name>--> (7/10,9/10) TEMİZLİK HİZMETİ *GT 117-Bölüm (3.2.10)+</cbc:Name>';
            $xmlStr .= '			<cbc:TaxTypeCode>602</cbc:TaxTypeCode>';
            $xmlStr .= '		</cac:TaxScheme>';
            $xmlStr .= '	</cac:TaxCategory>';
            $xmlStr .= '</cac:TaxSubtotal>';
            $xmlStr .= '</cac:WithholdingTaxTotal>';
        }
        $xmlStr .= '<cac:LegalMonetaryTotal>';
        $xmlStr .= '<cbc:LineExtensionAmount currencyID="'.$this->getDocumentCurrencyCode().'">'.$this->getSatirToplam().'</cbc:LineExtensionAmount>';
        $xmlStr .= '<cbc:TaxExclusiveAmount currencyID="'.$this->getDocumentCurrencyCode().'">'.$this->getVergiHaricToplam().'</cbc:TaxExclusiveAmount>';
        $xmlStr .= '<cbc:TaxInclusiveAmount currencyID="'.$this->getDocumentCurrencyCode().'">'.$this->getVergiDahilToplam().'</cbc:TaxInclusiveAmount>';
        if ($this->getToplamIskonto() > 0) {
            $xmlStr .= '<cbc:AllowanceTotalAmount currencyID="'.$this->getDocumentCurrencyCode().'">'.$this->getToplamIskonto().'</cbc:AllowanceTotalAmount>';
        }
        $xmlStr .= '<cbc:PayableAmount currencyID="'.$this->getDocumentCurrencyCode().'">'.$this->getOdenecekTutar().'</cbc:PayableAmount>';
        $xmlStr .= '</cac:LegalMonetaryTotal>';
        //Satırlar Ekleniyor
        if (count($lines) > 0) {
            foreach ($lines as $satir) {
                $xmlStr .= $satir->readXML();
            }
        }
        $xmlStr .= '</Invoice>';

        return $xmlStr;
    }
}
