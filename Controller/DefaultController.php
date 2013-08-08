<?php

namespace Ephp\ImapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {

    use \Ephp\UtilityBundle\Controller\Traits\BaseController;

    /**
     * @Route("/download/{email}/{id}/{name}", name="download_attach")
     */
    public function downloadAction($email, $id, $name) {
        $attach = $this->findOneBy('EphpImapBundle:Attach', array('body' => $email, 'id' => $id));
        /* @var $attach \Ephp\ImapBundle\Entity\Attach */
        $response = new Response();

        $contents = '';
        while (!feof($attach->getData())) {
            $contents .= fread($attach->getData(), 8192);
        }
        
        $tmp_dir = $this->dir()."/download/{$email}/{$id}";
        $tmp_file = $tmp_dir."/{$name}";
        if(!is_dir($tmp_dir)) {
            mkdir($tmp_dir, 0700, true);
        }
        $fp = fopen($tmp_file, 'w');
        fwrite($fp, $contents);
        fclose($fp);
        $mime = mime_content_type($tmp_file);
        unlink($tmp_file);
        rmdir($tmp_dir);
        rmdir($this->dir()."/download/{$email}");
        rmdir($this->dir()."/download");
        $response->setContent($contents);
        $response->headers->set('Content-Type', $mime);
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $attach->getFilename());

        return $response;
    }

    private function dir() {
        return str_replace($this->getRequest()->server->get('SCRIPT_NAME'), '', $this->getRequest()->server->get('SCRIPT_FILENAME'));
    }
    
}
