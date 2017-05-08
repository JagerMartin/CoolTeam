<?php
namespace AppBundle\Controller;

use AppBundle\Entity\TaxrefFile;
use AppBundle\Entity\TaxrefLinkFile;
use AppBundle\Form\TaxrefFileType;
use AppBundle\Form\TaxrefLinkFileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TaxrefController extends Controller
{
    /**
     * @Route("/taxref/charger", name="upload_taxref")
     *
     */
    public function showUploadFormsAction()
    {
        $taxrefFile = new TaxrefFile();
        $taxrefForm = $this->createForm(TaxrefFileType::class, $taxrefFile, array(
            'action' => $this->generateUrl('upload_taxref_taxref')
        ));

        $taxrefLinkFile = new TaxrefLinkFile();
        $taxrefLinkForm = $this->createForm(TaxrefLinkFileType::class, $taxrefLinkFile, array(
            'action' => $this->generateUrl('upload_taxref_taxreflink')
        ));

        return $this->render('admin/taxref/upload.html.twig', array(
            'taxrefForm' => $taxrefForm->createView(),
            'taxrefLinkForm' => $taxrefLinkForm->createView()
        ));
    }

    /**
     * @Route("/taxref/charger/taxref", name="upload_taxref_taxref")
     */
    public function uploadTaxrefAction(Request $request)
    {
        $taxrefFile = new TaxrefFile();
        $taxrefForm = $this->createForm(TaxrefFileType::class, $taxrefFile, array(
            'action' => $this->generateUrl('upload_taxref_taxref')
        ));

        $taxrefForm->handleRequest($request);
        if ($taxrefForm->isSubmitted() && $taxrefForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($taxrefFile);
            $em->flush();

            $this->addFlash('info', 'La table taxref a bien été téléchargée.');
            return $this->redirectToRoute('upload_taxref');
        }

        $this->addFlash('error', 'La table taxref n\'a pas été téléchargée.');
        return $this->redirectToRoute('upload_taxref');
    }

    /**
     * @Route("/taxref/charger/taxreflink", name="upload_taxref_taxreflink")
     */
    public function uploadTaxreflinkAction(Request $request)
    {
        $taxrefLinkFile = new TaxrefLinkFile();
        $taxrefLinkForm = $this->createForm(TaxrefLinkFileType::class, $taxrefLinkFile, array(
            'action' => $this->generateUrl('upload_taxref_taxreflink')
        ));

        $taxrefLinkForm->handleRequest($request);
        if ($taxrefLinkForm->isSubmitted() && $taxrefLinkForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($taxrefLinkFile);
            $em->flush();

            $this->addFlash('info', 'La table taxref_link a bien été téléchargée.');
            return $this->redirectToRoute('upload_taxref');
        }

        $this->addFlash('error', 'La table taxref_link n\'a pas été téléchargée.');
        return $this->redirectToRoute('upload_taxref');
    }
}