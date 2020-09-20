<?php


namespace App\Classes;



class GenerateQr
{ 
    //type = 1-> user ,2->eventin , 3->eventout, 4->floor, 5->gates
      
    public static function generateQrCode($type,$data){
        $Qr = new \SimpleSoftwareIO\QrCode\Generator();
        switch ($type){
            case 1:
                $Qr->generate($data, '../public/uploads/serviceproviderqr/sp'.$data.'.svg');
              return assetPath('uploads/serviceproviderqr/sp'.$data.'.svg');
                break;
            case 2:
                $Qr->generate($data, '../public/uploads/eventinqr/sp'.$data.'.svg');
                return assetPath('uploads/eventinqr/sp'.$data.'.svg');
                break;
                 case 3:
                $Qr->generate($data, '../public/uploads/eventoutqr/sp'.$data.'.svg');
                return assetPath('uploads/eventoutqr/sp'.$data.'.svg');
                break;
                 case 4:
                $Qr->generate($data, '../public/uploads/floorqr/sp'.$data.'.svg');
                return assetPath('uploads/floorqr/sp'.$data.'.svg');
                break;
                 case 5:
                $Qr->generate($data, '../public/uploads/gateqr/sp'.$data.'.svg');
                return assetPath('uploads/gateqr/sp'.$data.'.svg');
                break;
            default:
        }
    }

}
