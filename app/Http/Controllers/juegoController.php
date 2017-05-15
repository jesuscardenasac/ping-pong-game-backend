<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class juegoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = "select * from (
                select a.user, a.nombre,sum(a.ganados) ganados,sum(a.puntos) puntos from (
                select x.user_emisor user, x.nombre_emisor nombre, x.pemisor puntos, x.gana_emisor ganados from
                (select b.id_user_emisor user_emisor,emisor.name nombre_emisor,b.id_user_receptor user_receptor,receptor.name nombre_receptor,sum(juegospar.precep) preceptor,sum(juegospar.pemis) pemisor,
                
                sum(case when juegospar.gana_emisor > juegospar.gana_receptor then 1 else 0 end) gana_emisor,
                sum(case when juegospar.gana_emisor < juegospar.gana_receptor then 1 else 0 end) gana_receptor
                
                from solicitudes b
                inner join users emisor on emisor.id = b.id_user_emisor and b.estado = 'enviada'
                inner join users receptor on receptor.id = b.id_user_receptor and b.estado = 'enviada'
                inner join (select 
                a.id,a.id_solicitud, sum(b.puntos_receptor) precep, sum(b.puntos_emisor) pemis,
                sum(case when b.puntos_receptor > b.puntos_emisor then 1 when b.puntos_emisor > b.puntos_receptor then 0 end) gana_receptor,
                sum(case when b.puntos_receptor < b.puntos_emisor then 1 when b.puntos_emisor < b.puntos_receptor then 0 end) gana_emisor
                from juegos a
                inner join partidas b on a.id = b.id_juego and b.estado = 'iniciada'
                where b.puntos_receptor <> b.puntos_emisor
                group by a.id
                order by a.id,b.id) juegospar on juegospar.id_solicitud = b.id
                group by b.id_user_emisor,b.id_user_receptor) x
                
                union all
                
                select y.user_receptor user, y.nombre_receptor nombre, y.preceptor puntos, y.gana_receptor ganados from
                (select b.id_user_emisor user_emisor,emisor.name nombre_emisor,b.id_user_receptor user_receptor,receptor.name nombre_receptor,sum(juegospar.precep) preceptor,sum(juegospar.pemis) pemisor,
                
                sum(case when juegospar.gana_emisor > juegospar.gana_receptor then 1 else 0 end) gana_emisor,
                sum(case when juegospar.gana_emisor < juegospar.gana_receptor then 1 else 0 end) gana_receptor
                
                from solicitudes b
                inner join users emisor on emisor.id = b.id_user_emisor and b.estado = 'enviada'
                inner join users receptor on receptor.id = b.id_user_receptor and b.estado = 'enviada'
                inner join (select 
                a.id,a.id_solicitud, sum(b.puntos_receptor) precep, sum(b.puntos_emisor) pemis,
                sum(case when b.puntos_receptor > b.puntos_emisor then 1 when b.puntos_emisor > b.puntos_receptor then 0 end) gana_receptor,
                sum(case when b.puntos_receptor < b.puntos_emisor then 1 when b.puntos_emisor < b.puntos_receptor then 0 end) gana_emisor
                from juegos a
                inner join partidas b on a.id = b.id_juego and b.estado = 'iniciada'
                where b.puntos_receptor <> b.puntos_emisor
                group by a.id
                order by a.id,b.id) juegospar on juegospar.id_solicitud = b.id
                group by b.id_user_emisor,b.id_user_receptor) y ) a
                group by a.user) b order by ganados desc";
                    
        $honor = DB::select($query);
        
        return response($honor)->header('Access-Control-Allow-Origin','*');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $query = "select a.id_solicitud, a.user_emisor oponente, a.nombre_emisor nom_oponente, a.pemis puntos_oponente, a.gana_emisor gana_oponente , a.precep mis_puntos, a.gana_receptor mis_ganadas from (select b.id idsolicitud,b.id_user_emisor user_emisor,emisor.name nombre_emisor,b.id_user_receptor user_receptor,receptor.name nombre_receptor, juegpar.*
                from solicitudes b
                inner join users emisor on emisor.id = b.id_user_emisor and b.estado = 'enviada'
                inner join users receptor on receptor.id = b.id_user_receptor  and b.estado = 'enviada'
                inner join (select 
                a.id,a.id_solicitud, sum(b.puntos_receptor) precep, sum(b.puntos_emisor) pemis,
                sum(case when b.puntos_receptor > b.puntos_emisor then 1 when b.puntos_emisor > b.puntos_receptor then 0 end) gana_receptor,
                sum(case when b.puntos_receptor < b.puntos_emisor then 1 when b.puntos_emisor < b.puntos_receptor then 0 end) gana_emisor
                from juegos a
                inner join partidas b on a.id = b.id_juego and b.estado = 'iniciada'
                where b.puntos_receptor <> b.puntos_emisor
                group by a.id
                order by a.id,b.id) juegpar on juegpar.id_solicitud = b.id
                where emisor.id = ".$id." or receptor.id = ".$id.") a
                where a.user_receptor = ".$id."
                
                union all
                
                select a.id_solicitud, a.user_receptor oponente, a.nombre_receptor nom_oponente, a.precep puntos_oponente, a.gana_receptor gana_oponente , a.pemis mis_puntos, a.gana_emisor mis_ganadas from (select b.id idsolicitud,b.id_user_emisor user_emisor,emisor.name nombre_emisor,b.id_user_receptor user_receptor,receptor.name nombre_receptor, juegpar.*
                from solicitudes b
                inner join users emisor on emisor.id = b.id_user_emisor and b.estado = 'enviada'
                inner join users receptor on receptor.id = b.id_user_receptor  and b.estado = 'enviada'
                inner join (select 
                a.id,a.id_solicitud, sum(b.puntos_receptor) precep, sum(b.puntos_emisor) pemis,
                sum(case when b.puntos_receptor > b.puntos_emisor then 1 when b.puntos_emisor > b.puntos_receptor then 0 end) gana_receptor,
                sum(case when b.puntos_receptor < b.puntos_emisor then 1 when b.puntos_emisor < b.puntos_receptor then 0 end) gana_emisor
                from juegos a
                inner join partidas b on a.id = b.id_juego and b.estado = 'iniciada'
                where b.puntos_receptor <> b.puntos_emisor
                group by a.id
                order by a.id,b.id) juegpar on juegpar.id_solicitud = b.id
                where emisor.id = ".$id." or receptor.id = ".$id.") a
                where a.user_emisor = ".$id;
                    
        $juegos = DB::select($query);
        
        return response($juegos)->header('Access-Control-Allow-Origin','*');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
