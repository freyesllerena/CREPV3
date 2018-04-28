<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use AppBundle\Entity\Crep;
use AppBundle\Entity\CrepMindef01;
use TCPDF;
use Doctrine\ORM\Tools\SchemaTool;
use AppBundle\Entity\ModeleCrep;

//CREP7\vendor\tecnickcom\tcpdf\examples\tcpdf_include.php
//require_once('C:\Users\kben-daali-adc\Applications\XAMPP7\htdocs\CREP7\vendor\tecnickcom\tcpdf\examples\tcpdf_include.php');
// require_once('C:\Users\kben-daali-adc\Applications\XAMPP7\htdocs\CREP7\vendor\tecnickcom\tcpdf\tcpdf.php');
//require_once('PEAR.php');

class DefaultController extends Controller
{
    public function testAction()
    {
        $ministere = $this->getUser()->getMinistere();

        $modele1 = new ModeleCrep();
        $modele1->setActif(1)->setCreePar($this->getUser());
        $modele1->setMinistere($ministere)->setLibelle('Modèle_mindef_01');
        $modele1->setTypeEntity('AppBundle\Entity\CrepMindef01');

        $modele2 = new ModeleCrep();
        $modele2->setActif(1)->setCreePar($this->getUser());
        $modele2->setMinistere($ministere)->setLibelle('Modèle_mindef_02');
        $modele2->setTypeEntity('AppBundle\Entity\CrepMindef01');

        $em = $this->getDoctrine()->getManager();
        $em->persist($modele1);
        $em->persist($modele2);

        $em->flush();

        return new Response("that's right ! ");
//         $HTTP_CLIENT_IP=isset($_SERVER['HTTP_CLIENT_IP'])?$_SERVER['HTTP_CLIENT_IP']:null;                      // null | null
//         $HTTP_X_FORWARDED_FOR=isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:null;    // 172.24.38.56, 172.26.0.92 | null
//         $REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];                                                                   // 172.26.134.207 | 127.0.0.1

        $template = 'vide.html.twig';

        return $this->render($template);

        $SERVER = print_r($_SERVER, true);

        //return new Response($this->generateUrl('accueil', array(), UrlGeneratorInterface::ABSOLUTE_URL));

        return new Response($SERVER);

        $em = $this->getDoctrine()->getManager();
        $schemaTool = new SchemaTool($em);
        $metadatas = $em->getMetadataFactory()->getAllMetadata();
        $sqls = $schemaTool->getCreateSchemaSql($metadatas);

        dump($sqls);
        $template = 'vide.html.twig';

        return $this->render($template);
    }

    public function testCertificatAction(CrepMindef01 $crep)
    {
        return $this->testTcpdf();

        $template = 'crep/crepMindef01/crepMindef01.html.twig';

        $html = $this->renderView($template, array(
            'crep' => $crep,
        ));

        /* @var $pdf TCPDF */
        $pdf = $this->get('white_october.tcpdf')->create();

        // set default header data
        //$pdf->SetHeaderData("/../../../../../app/Resources/views/crep/crepMindef/logo.png", PDF_HEADER_LOGO_WIDTH, 'COMPTE RENDU D\'ENTRETIEN PROFESSIONNEL', "rÃ©alisÃ© au titre de l'annÃ©e 2016");
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 061', PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/../Resources/lang/fra.php')) {
            require_once dirname(__FILE__).'/../Resources/lang/fra.php';
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------
        // set certificate file
        $certificate = dirname(__FILE__).'/../../../../../../tmp/server.crt';

        // openssl req -x509 -nodes -days 365000 -newkey rsa:1024 -keyout private_key.crt -out certificate.crt
        $certificate = 'file://'.realpath('/tmp/certificate.crt');
        $pricateKey = 'file://'.realpath('/tmp/private_key.crt');
        $certificate = 'file://'.realpath('C:\Users\kben-daali-adc\Applications\XAMPP\htdocs\CREPV2\install\certificat\certificat.crt');

        // set additional information
        $info = array(
            'Name' => 'Expérimentation MINDEF 1',
            'Location' => 'CISIRH',
            'Reason' => 'Expérimentation MINDEF 2',
            'ContactInfo' => 'https://degas.cisirh.rie.gouv.fr',
        );

        // set document signature
        $pdf->setSignature($certificate, $certificate, '', '', 1, $info);
        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', '', 10);

        // add a page
//         $pdf->AddPage();
//         $template = 'page1.html.twig';
//         $page1 = $this->renderView($template, array(
//             "crep" => null
//         ));

//         $pdf->writeHTML($page1, true, false, true, false, '');

        // add a page
        $pdf->AddPage();
        //$template = 'page2.html.twig';
        $page2 = $this->renderView($template, array(
            'crep' => $crep,
        ));

        $pdf->writeHTML($page2, true, false, true, false, '');
        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('example_001.pdf', 'I');

        /*

                exit();
                return new Response(
                    $snappy->getOutputFromHtml($html, array(
                        'lowquality' => false,
                        'encoding' => 'UTF-8',
                        'images' => true,
                        'footer-right'=>'[page] / [topage]',
                        'footer-left'=>"ministÃ¨re",
                    )),
                    200,
                    array(
                        'Content-Type'          => 'application/pdf',
                        'Content-Disposition'   => 'inline; filename="toto.pdf"' ///inline //attachment
                    )
                );
                */
        //return new Response($html);
        return $this->render($template);
    }

    public function indexAction(Crep $crep)
    {
        $template = 'crep/crepMindef/crepHtmlPdf/modele_mindef_v1.html.twig';

        $template = $this->renderView($template, array(
                'crep' => $crep,
            ));

        return $this->render($template);
    }

    /**
     *  Render in a PDF the sandbox_homepage URL.
     *
     * @return Response
     */
    public function pdfAction(Crep $crep)
    {
        $snappy = $this->get('knp_snappy.pdf');

        $html = $this->renderView('crep/crepMindef/crepHtmlPdf/modele_mindef_v1.html.twig', array(
            'crep' => $crep,
            //..Send some data to your view if you need to //
        ));

        $filename = 'myFirstSnappyPDF';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$filename.'.pdf"', ///attachment
            )
        );
    }

    public function testTcpdf()
    {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        //$pdf = $this->get("white_october.tcpdf")->create();

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('TCPDF Example 052');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 052', PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once dirname(__FILE__).'/lang/eng.php';
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        /*
         NOTES:
         - To create self-signed signature: openssl req -x509 -nodes -days 365000 -newkey rsa:1024 -keyout tcpdf.crt -out tcpdf.crt
         - To export crt to p12: openssl pkcs12 -export -in tcpdf.crt -out tcpdf.p12
         - To convert pfx certificate to pem: openssl pkcs12 -in tcpdf.pfx -out tcpdf.crt -nodes
         */

        // set certificate file
        //$certificate = 'file://data/cert/tcpdf.crt';
        $certificate = 'file://'.realpath('C:\Users\kben-daali-adc\Applications\XAMPP7\htdocs\CREP7\vendor\tecnickcom\tcpdf\examples\data\cert\tcpdf.crt');
        //$certificate = 'file://'.realpath('C:\Users\kben-daali-adc\Applications\XAMPP7\htdocs\CREP7\vendor\tecnickcom\tcpdf\examples\data\cert\tcpdf.p12');

        // set additional information
        $info = array(
                'Name' => 'TCPDF',
                'Location' => 'Office',
                'Reason' => 'Testing TCPDF',
                'ContactInfo' => 'http://www.tcpdf.org',
        );

        // set document signature
        $pdf->setSignature($certificate, $certificate, 'tcpdfdemo', '', 2, $info);

        // set font
        $pdf->SetFont('helvetica', '', 12);

        // add a page
        $pdf->AddPage();

        // print a line of text
        $text = 'This is a <b color="#FF0000">digitally signed document</b> using the default (example) <b>tcpdf.crt</b> certificate.<br />To validate this signature you have to load the <b color="#006600">tcpdf.fdf</b> on the Arobat Reader to add the certificate to <i>List of Trusted Identities</i>.<br /><br />For more information check the source code of this example and the source code documentation for the <i>setSignature()</i> method.<br /><br /><a href="http://www.tcpdf.org">www.tcpdf.org</a>';
        $pdf->writeHTML($text, true, 0, true, 0);

        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // *** set signature appearance ***

        // create content for signature (image and/or text)
        $pdf->Image('images/tcpdf_signature.png', 180, 60, 15, 15, 'PNG');

        // define active area for signature appearance
        $pdf->setSignatureAppearance(180, 60, 15, 15);

        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // *** set an empty signature appearance ***
        $pdf->addEmptySignatureAppearance(180, 80, 15, 15);

        // ---------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('example_052.pdf', 'D');

        //============================================================+
        // END OF FILE
        //============================================================+
    }
}
