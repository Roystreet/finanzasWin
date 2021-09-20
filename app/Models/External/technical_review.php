<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Model;

class technical_review extends Model
{
  protected $table      = 'technical_reviews';
  protected $fillable   = ['id_file_drivers','luz_baja','luz_alta','luz_freno','luz_emergencia','luz_retroceso','luz_intermitente','luz_antiniebla','luz_placa','arranque_motor','arrancador',
                          'alternador','bujias','cable_bujias','bobinas','inyectores','bateria','past_del','past_tras','disc_del','disc_tras','tamb_tras','zapatas_tras','freno_emerg','liq_freno',
                          'est_neumaticos','rev_tuercas','pres_neumat','llanta_resp','aros','paracho_del','paracho_post','puert_del_izq','puert_del_der','puert_post_izq','puert_post_der',
                          'guardafango_izq','guardafango_der','capota','vid_del_izq','vid_del_der','vid_post_izq','vid_post_der','parab_del','parab_tras','maletero','techo','fuga_aceite','fuga_refrig','fuga_combust',
                          'filt_aceite','filt_aire','filt_combus','filt_cabina','bomba_direc','amorti_del','amorti_post','palieres','rotulas','termin_direc','trapezios','resortes','aceite_caja',
                          'filtro_caja','caja_transf','cardan','diferencial','disco_embrague','collarin','cruzetas','radiador','ventiladores','correa_vent','mangueras_agua','tablero','luz_tablero',
                          'luz_saloom','asiento_piloto','asiento_copiloto','asientos_tras','claxon','gata','llave_ruedas','estuche_herra','triangulo_seg','extintor','note','created_at','updated_at','status_system'];

  public function getfileDrivers()
  {
    return $this->belongsTo(file_drivers::class,     'id_file_drivers')->withDefault([
      'id' => '0'
    ]);
  }

}
