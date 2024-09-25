<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PdfController extends AbstractController
{

    #[Route('/pdf', name: 'app_pdf')]
    public function generatePdf(): Response
    {
        // Configuración opcional
        $options = new Options();
        $options->set('defaultFont', 'Arial');

        // Inicializar Dompdf
        $dompdf = new Dompdf($options);

        // Generar HTML
        $html = $this->renderView('pdf/index.html.twig', [
            'some_data' => 'Aquí puedes pasar datos',
        ]);

        // Cargar HTML en DOMPDF
        $dompdf->loadHtml($html);

        // Configurar el tamaño de página y la orientación
        $dompdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $dompdf->render();

        // Generar la respuesta en PDF
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="archivo.pdf"',
        ]);
    }
}
