@extends('emails.main')




@section('preview') {{$emailParams["preview"]}} @stop

@section('subject') {{$emailParams["subject"]}} @stop


@section('content')
<td align="center" valign="top" id="templateBody" data-template-container>
    <!--[if (gte mso 9)|(IE)]>
    <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
    <tr>
    <td align="center" valign="top" width="600" style="width:600px;">
    <![endif]-->
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
        <tr>
            <td valign="top" class="bodyContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                    <tbody class="mcnTextBlockOuter">
                        <tr>
                            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                <!--[if mso]>
                                                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                                <tr>
                                                <![endif]-->

                                <!--[if mso]>
                                <td valign="top" width="600" style="width:600px;">
                                <![endif]-->
                                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                    <tbody><tr>

                                            <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">

                                                <h2>Bienvenid@ {{$user->name}} a Alquiler Directo</h2>

                                                <p style="font-size:18px !important;">Si estas <strong>buscando</strong> una propiedad para {{config('country.'.Session::get('country_id'))["rent_name"]}}, en <span style="color:#c01d26"><strong>Alquiler Directo</strong></span> encontraras cientos de posibilidades cerca a ti.</p>

                                                <p style="font-size:18px !important;">Si quieres <strong>vender</strong> o <strong>{{config('country.'.Session::get('country_id'))["rent_name"]}}</strong>, <strong><span style="color:#c01d26">Alquiler Directo</span></strong> es tu mejor opción, cientos de personas nos visitan diariamente y tenemos unos de los grupos mas grandes de propiedades en facebook, puedes comenzar <strong><span style="color:#c01d26">gratis</span></strong> ahora!</p>

                                            </td>
                                        </tr>
                                    </tbody></table>
                                <!--[if mso]>
                                </td>
                                <![endif]-->

                                <!--[if mso]>
                                </tr>
                                </table>
                                <![endif]-->
                            </td>
                        </tr>
                    </tbody>
                </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
                    <tbody class="mcnDividerBlockOuter">
                        <tr>
                            <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 18px 18px 0px;">
                                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;">
                                    <tbody><tr>
                                            <td>
                                                <span></span>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                <!--            
                                                <td class="mcnDividerBlockInner" style="padding: 18px;">
                                                <hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
                                -->
                            </td>
                        </tr>
                    </tbody>
                </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
                    <tbody class="mcnButtonBlockOuter">
                        <tr>
                            <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
                                <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border-radius: 3px;background-color: #95C41F;">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Helvetica; font-size: 18px; padding: 18px;">
                                                <a class="mcnButton " title="Ingresa ahora" href="{{url('/')}}" target="_self" style="font-weight: bold;letter-spacing: -0.5px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Ingresa Ahora!</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
                    <tbody class="mcnDividerBlockOuter">
                        <tr>
                            <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;">
                                    <tbody><tr>
                                            <td>
                                                <span></span>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                <!--            
                                                <td class="mcnDividerBlockInner" style="padding: 18px;">
                                                <hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
                                -->
                            </td>
                        </tr>
                    </tbody>
                </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
                    <tbody class="mcnDividerBlockOuter">
                        <tr>
                            <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;">
                                    <tbody><tr>
                                            <td>
                                                <span></span>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                <!--            
                                                <td class="mcnDividerBlockInner" style="padding: 18px;">
                                                <hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
                                -->
                            </td>
                        </tr>
                    </tbody>
                </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCaptionBlock">
                    <tbody class="mcnCaptionBlockOuter">
                        <tr>
                            <td class="mcnCaptionBlockInner" valign="top" style="padding:9px;">


                                <table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnCaptionBottomContent">
                                    <tbody><tr>
                                            <td class="mcnCaptionBottomImageContent" align="center" valign="top" style="padding:0 9px 9px 9px;">



                                                <img alt="" src="https://gallery.mailchimp.com/ec8ab7276866f9c6bf371c646/images/cf6407da-11f1-4614-a9d8-3c53a49f6bd0.png" width="564" style="max-width:1263px;" class="mcnImage">


                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="mcnTextContent" valign="top" style="padding:0 9px 0 9px;" width="564">
                                                <h3>Encuentra en menos tiempo</h3>

                                                <p>Con nuestros buscadores,&nbsp;nuestro mapa y nuestras notificaciones inteligentes, encuentra mucho mas rápido y fácil la propiedad que estas buscando</p>

                                            </td>
                                        </tr>
                                    </tbody></table>





                            </td>
                        </tr>
                    </tbody>
                </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
                    <tbody class="mcnDividerBlockOuter">
                        <tr>
                            <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;">
                                    <tbody><tr>
                                            <td>
                                                <span></span>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                <!--            
                                                <td class="mcnDividerBlockInner" style="padding: 18px;">
                                                <hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
                                -->
                            </td>
                        </tr>
                    </tbody>
                </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnBoxedTextBlock" style="min-width:100%;">
                    <!--[if gte mso 9]>
                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
                        <![endif]-->
                    <tbody class="mcnBoxedTextBlockOuter">
                        <tr>
                            <td valign="top" class="mcnBoxedTextBlockInner">

                                <!--[if gte mso 9]>
                                <td align="center" valign="top" ">
                                <![endif]-->
                                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnBoxedTextContentContainer">
                                    <tbody><tr>

                                            <td style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:18px;">

                                                <table border="0" cellspacing="0" class="mcnTextContentContainer" width="100%" style="min-width: 100% !important;background-color: #F7F7F7;">
                                                    <tbody><tr>
                                                            <td valign="top" class="mcnTextContent" style="padding: 18px; text-align: center;">
                                                                <h3 style="text-align:center;">¿Necesitas publicar una propiedad?</h3>

                                                                <p style="text-align:center !important;">Puedes comenzar totalmente <span style="color:#c01d26">gratis</span> y hasta que tu propiedad se alquile o venda</p>

                                                            </td>
                                                        </tr>
                                                    </tbody></table>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
                    <tbody class="mcnButtonBlockOuter">
                        <tr>
                            <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
                                <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border-radius: 3px;background-color: #95C41F;">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Helvetica; font-size: 18px; padding: 18px;">
                                                <a class="mcnButton " title="Ingresa ahora!" href="{{route('crearPropiedad')}}" target="_self" style="font-weight: bold;letter-spacing: -0.5px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Publicar una propiedad</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                                
                                <!--[if gte mso 9]>
                                </td>
                                <![endif]-->

                                <!--[if gte mso 9]>
                </tr>
                </table>
                                <![endif]-->
                            </td>
                        </tr>
                    </tbody>
                </table></td>
        </tr>
    </table>
    <!--[if (gte mso 9)|(IE)]>
    </td>
    </tr>
    </table>
    <![endif]-->
</td>

@stop