<?php
 
/*
Plugin Name: WeStorage Tarifas Couriers v2.0.0
Plugin URI: https://www.westorage.cl/
Description: WooCommerce Tarifa Couriers WeStorage Chile.
Version: 2.0.0
Author: Westorage
License: GPL-3.0+
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Domain Path: /lang
Text Domain: Enviame
*/

require_once plugin_dir_path( __FILE__ )."/classes/woocoomerce-comunas.php";
require_once plugin_dir_path( __FILE__ )."/classes/comunas.php";

if ( ! defined( 'WPINC' ) ) {
    die;
}
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 
  $enviame_default = array(
    'plugin_path' => trailingslashit( plugin_dir_path(__FILE__) ),
  );
    function enviame_shipping_method() {
        if ( ! class_exists( 'enviame_shipping_method' ) ) {
            class enviame_shipping_method extends WC_Shipping_Method {
                public function __construct() {
                    $this->id                 = 'enviame'; 
                    $this->method_title       = __( 'WeStorage Tarifa Couriers', 'enviame' );  
                    $this->method_description = __( 'Tarifa Couriers WeStorage Chile.', 'enviame' ); 
                    //Valido que solo sea usado con Chilito [CL]
                    $this->availability = 'including';
                    $this->countries = array( 'CL' );
                    $this->init();
                    $this->enabled = isset( $this->settings['enabled'] ) ? $this->settings['enabled'] : 'yes';
                    $this->title = isset( $this->settings['title'] ) ? $this->settings['title'] : __( 'WooCommerce Enviame', 'enviame' );
                }
                function init() {
                    $this->init_form_fields(); 
                    $this->init_settings(); 
                    add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
                }
                function init_form_fields() { 
                   $states = array('CL' => '');
				   $comunas = enviame_comunas($states);
				   
				   $comunas_array = array(
                    'Antofagasta' => __( 'Antofagasta' ),
                    'Calama' => __( 'Calama' ),
                    'María Elena' => __( 'María Elena' ),
                    'Mejillones' => __( 'Mejillones' ),
                    'Ollagüe' => __( 'Ollagüe' ),
                    'San Pedro de Atacama' => __( 'San Pedro de Atacama' ),
                    'Sierra Gorda' => __( 'Sierra Gorda' ),
                    'Taltal' => __( 'Taltal' ),
                    'Tocopilla' => __( 'Tocopilla' ),
                    'Arica' => __( 'Arica' ),
                    'Camarones' => __( 'Camarones' ),
                    'General Lagos' => __( 'General Lagos' ),
                    'Putre' => __( 'Putre' ),
                    'Alto del Carmen' => __( 'Alto del Carmen' ),
                    'Caldera' => __( 'Caldera' ),
                    'Chañaral' => __( 'Chañaral' ),
                    'Copiapó' => __( 'Copiapó' ),
                    'Diego de Almagro' => __( 'Diego de Almagro' ),
                    'Freirina' => __( 'Freirina' ),
                    'Huasco' => __( 'Huasco' ),
                    'Tierra Amarilla' => __( 'Tierra Amarilla' ),
                    'Vallenar' => __( 'Vallenar' ),
                    'Aysén' => __( 'Aysén' ),
                    'Chile Chico' => __( 'Chile Chico' ),
                    'Cisnes' => __( 'Cisnes' ),
                    'Cochrane' => __( 'Cochrane' ),
                    'Coyhaique' => __( 'Coyhaique' ),
                    'Guaitecas' => __( 'Guaitecas' ),
                    'Lago Verde' => __( 'Lago Verde' ), 
                    'Río Ibáñez' => __( 'Río Ibáñez' ),
                    'Tortel' => __( 'Tortel' ),
                    'Alto Biobío' => __( 'Alto Biobío' ),
                    'Antuco' => __( 'Antuco' ),
                    'Arauco' => __( 'Arauco' ),
                    'Cabrero' => __( 'Cabrero' ),
                    'Cañete' => __( 'Cañete' ),
                    'Chiguayante' => __( 'Chiguayante' ),
                    'Concepción' => __( 'Concepción' ),
                    'Contulmo' => __( 'Contulmo' ),
                    'Coronel' => __( 'Coronel' ),
                    'Curanilahue' => __( 'Curanilahue' ),
                    'Florida' => __( 'Florida' ),
                    'Hualpén' => __( 'Hualpén' ),
                    'Hualqui' => __( 'Hualqui' ),
                    'Laja' => __( 'Laja' ),
                    'Lebu' => __( 'Lebu' ),
                    'Los Álamos' => __( 'Los Álamos' ),
                    'Los Ángeles' => __( 'Los Ángeles' ),
                    'Lota' => __( 'Lota' ),
                    'Mulchén' => __( 'Mulchén' ),
                    'Nacimiento' => __( 'Nacimiento' ),
                    'Negrete' => __( 'Negrete' ),
                    'Penco' => __( 'Penco' ),
                    'Quilaco' => __( 'Quilaco' ),
                    'Quilleco' => __( 'Quilleco' ),
                    'San Pedro de La Paz' => __( 'San Pedro de La Paz' ),
                    'San Rosendo' => __( 'San Rosendo' ),
                    'Santa Bárbara' => __( 'Santa Bárbara' ),
                    'Santa Juana' => __( 'Santa Juana' ),
                    'Talcahuano' => __( 'Talcahuano' ),
                    'Tirúa' => __( 'Tirúa' ),
                    'Tomé' => __( 'Tomé' ),
                    'Tucapel' => __( 'Tucapel' ),
                    'Yumbel' => __( 'Yumbel' ),
                    'Bulnes' => __( 'Bulnes' ),
                    'Chillán' => __( 'Chillán' ),
                    'Chillán Viejo' => __( 'Chillán Viejo' ),
                    'Cobquecura' => __( 'Cobquecura' ),
                    'Coelemu' => __( 'Coelemu' ),
                    'Coihueco' => __( 'Coihueco' ),
                    'El Carmen' => __( 'El Carmen' ),
                    'Ninhue' => __( 'Ninhue' ),
                    'Ñiquén' => __( 'Ñiquén' ),
                    'Pemuco' => __( 'Pemuco' ),
                    'Pinto' => __( 'Pinto' ),
                    'Portezuelo' => __( 'Portezuelo' ),
                    'Quillón' => __( 'Quillón' ),
                    'Quirihue' => __( 'Quirihue' ),
                    'Ránquil' => __( 'Ránquil' ),
                    'San Carlos' => __( 'San Carlos' ),
                    'San Fabián' => __( 'San Fabián' ),
                    'San Ignacio' => __( 'San Ignacio' ),
                    'San Nicolás' => __( 'San Nicolás' ),
                    'Treguaco' => __( 'Treguaco' ),
                    'Yungay' => __( 'Yungay' ),
                    'Andacollo' => __( 'Andacollo' ),
                    'Canela' => __( 'Canela' ),
                    'Combarbalá' => __( 'Combarbalá' ),
                    'Coquimbo' => __( 'Coquimbo' ),
                    'Illapel' => __( 'Illapel' ),
                    'La Higuera' => __( 'La Higuera' ),
                    'La Serena' => __( 'La Serena' ),
                    'Los Vilos' => __( 'Los Vilos' ),
                    'Monte Patria' => __( 'Monte Patria' ),
                    'Ovalle' => __( 'Ovalle' ),
                    'Paihuano' => __( 'Paihuano' ),
                    'Punitaqui' => __( 'Punitaqui' ),
                    'Río Hurtado' => __( 'Río Hurtado' ),
                    'Salamanca' => __( 'Salamanca' ),
                    'Vicuña' => __( 'Vicuña' ),
                    'Angol' => __( 'Angol' ),
                    'Carahue' => __( 'Carahue' ),
                    'Cholchol' => __( 'Cholchol' ),
                    'Collipulli' => __( 'Collipulli' ),
                    'Cunco' => __( 'Cunco' ),
                    'Curacautín' => __( 'Curacautín' ),
                    'Curarrehue' => __( 'Curarrehue' ),
                    'Ercilla' => __( 'Ercilla' ),
                    'Freire' => __( 'Freire' ),
                    'Galvarino' => __( 'Galvarino' ),
                    'Gorbea' => __( 'Gorbea' ),
                    'Lautaro' => __( 'Lautaro' ),
                    'Loncoche' => __( 'Loncoche' ),
                    'Lonquimay' => __( 'Lonquimay' ),
                    'Los Sauces' => __( 'Los Sauces' ),
                    'Lumaco' => __( 'Lumaco' ),
                    'Melipeuco' => __( 'Melipeuco' ),
                    'Nueva Imperial' => __( 'Nueva Imperial' ),
                    'Padre Las Casas' => __( 'Padre Las Casas' ),
                    'Perquenco' => __( 'Perquenco' ),
                    'Pitrufquén' => __( 'Pitrufquén' ),
                    'Pucón' => __( 'Pucón' ),
                    'Purén' => __( 'Purén' ),
                    'Renaico' => __( 'Renaico' ),
                    'Saavedra' => __( 'Saavedra' ),
                    'Temuco' => __( 'Temuco' ),
                    'Teodoro Schmidt' => __( 'Teodoro Schmidt' ),
                    'Toltén' => __( 'Toltén' ),
                    'Traiguén' => __( 'Traiguén' ),
                    'Victoria' => __( 'Victoria' ),
                    'Vilcún' => __( 'Vilcún' ),
                    'Villarrica' => __( 'Villarrica' ),
                    'Chépica' => __( 'Chépica' ),
                    'Chimbarongo' => __( 'Chimbarongo' ),
                    'Codegua' => __( 'Codegua' ),
                    'Coinco' => __( 'Coinco' ),
                    'Coltauco' => __( 'Coltauco' ),
                    'Doñihue' => __( 'Doñihue' ),
                    'Graneros' => __( 'Graneros' ),
                    'La Estrella' => __( 'La Estrella' ),
                    'Las Cabras' => __( 'Las Cabras' ),
                    'Litueche' => __( 'Litueche' ),
                    'Lolol' => __( 'Lolol' ),
                    'Machalí' => __( 'Machalí' ),
                    'Malloa' => __( 'Malloa' ),
                    'Marchihue' => __( 'Marchihue' ),
                    'Mostazal' => __( 'Mostazal' ),
                    'Nancagua' => __( 'Nancagua' ),
                    'Navidad' => __( 'Navidad' ),
                    'Olivar' => __( 'Olivar' ),
                    'Palmilla' => __( 'Palmilla' ),
                    'Paredones Chépica' => __( 'Paredones Chépica' ),
                    'Chimbarongo' => __( 'Chimbarongo' ),
                    'Codegua' => __( 'Codegua' ),
                    'Coinco' => __( 'Coinco' ),
                    'Coltauco' => __( 'Coltauco' ),
                    'Doñihue' => __( 'Doñihue' ),
                    'Graneros' => __( 'Graneros' ),
                    'La Estrella' => __( 'La Estrella' ),
                    'Las Cabras' => __( 'Las Cabras' ),
                    'Litueche' => __( 'Litueche' ),
                    'Lolol' => __( 'Lolol' ),
                    'Machalí' => __( 'Machalí' ),
                    'Malloa' => __( 'Malloa' ),
                    'Marchihue' => __( 'Marchihue' ),
                    'Mostazal' => __( 'Mostazal' ),
                    'Nancagua' => __( 'Nancagua' ),
                    'Navidad' => __( 'Navidad' ),
                    'Olivar' => __( 'Olivar' ),
                    'Palmilla' => __( 'Palmilla' ),
                    'Paredones' => __( 'Paredones' ),
                    'Peralillo' => __( 'Peralillo' ),
                    'Peumo' => __( 'Peumo' ),
                    'Pichidegua' => __( 'Pichidegua' ),
                    'Pichilemu' => __( 'Pichilemu' ),
                    'Placilla' => __( 'Placilla' ),
                    'Pumanque' => __( 'Pumanque' ),
                    'Quinta de Tilcoco' => __( 'Quinta de Tilcoco' ),
                    'Rancagua' => __( 'Rancagua' ),
                    'Rengo' => __( 'Rengo' ),
                    'Requínoa' => __( 'Requínoa' ),
                    'San Fernando' => __( 'San Fernando' ),
                    'San Vicente' => __( 'San Vicente' ),
                    'Santa Cruz' => __( 'Santa Cruz' ),
                    'Ancud' => __( 'Ancud' ),
                    'Calbuco' => __( 'Calbuco' ),
                    'Castro' => __( 'Castro' ),
                    'Chaitén' => __( 'Chaitén' ),
                    'Chonchi' => __( 'Chonchi' ),
                    'Cochamó' => __( 'Cochamó' ),
                    'Curaco de Vélez' => __( 'Curaco de Vélez' ),
                    'Dalcahue' => __( 'Dalcahue' ),
                    'Fresia' => __( 'Fresia' ),
                    'Frutillar' => __( 'Frutillar' ),
                    'Futaleufú' => __( 'Futaleufú' ),
                    'Hualaihué' => __( 'Hualaihué' ),
                    'Llanquihue' => __( 'Llanquihue' ),
                    'Los Muermos' => __( 'Los Muermos' ),
                    'Maullín' => __( 'Maullín' ),
                    'Osorno' => __( 'Osorno' ),
                    'Palena' => __( 'Palena' ),
                    'Puerto Montt' => __( 'Puerto Montt' ),
                    'Puerto Octay' => __( 'Puerto Octay' ),
                    'Puerto Varas' => __( 'Puerto Varas' ),
                    'Puqueldón' => __( 'Puqueldón' ),
                    'Purranque' => __( 'Purranque' ),
                    'Puyehue' => __( 'Puyehue' ),
                    'Queilén' => __( 'Queilén' ),
                    'Quellón' => __( 'Quellón' ),
                    'Quemchi' => __( 'Quemchi' ),
                    'Quinchao' => __( 'Quinchao' ),
                    'Río Negro' => __( 'Río Negro' ),
                    'San Juan de la Costa' => __( 'San Juan de la Costa' ),
                    'San Pablo' => __( 'San Pablo' ),
                    'Corral' => __( 'Corral' ),
                    'Futrono' => __( 'Futrono' ),
                    'La Unión' => __( 'La Unión' ),
                    'Lago Ranco' => __( 'Lago Ranco' ),
                    'Lanco' => __( 'Lanco' ),
                    'Los Lagos' => __( 'Los Lagos' ),
                    'Máfil' => __( 'Máfil' ),
                    'Mariquina' => __( 'Mariquina' ),
                    'Paillaco' => __( 'Paillaco' ),
                    'Panguipulli' => __( 'Panguipulli' ),
                    'Río Bueno' => __( 'Río Bueno' ),
                    'Valdivia' => __( 'Valdivia' ),
                    'Antártica' => __( 'Antártica' ),
                    'Cabo de Hornos' => __( 'Cabo de Hornos' ),
                    'Laguna Blanca' => __( 'Laguna Blanca' ),
                    'Natales' => __( 'Natales' ),
                    'Porvenir' => __( 'Porvenir' ),
                    'Primavera' => __( 'Primavera' ),
                    'Punta Arenas' => __( 'Punta Arenas' ),
                    'Río Verde' => __( 'Río Verde' ),
                    'San Gregorio' => __( 'San Gregorio' ),
                    'Timaukel' => __( 'Timaukel' ),
                    'Torres del Paine' => __( 'Torres del Paine' ),
                    'Cauquenes' => __( 'Cauquenes' ),
                    'Chanco' => __( 'Chanco' ),
                    'Colbún' => __( 'Colbún' ),
                    'Constitución' => __( 'Constitución' ),
                    'Curepto' => __( 'Curepto' ),
                    'Curicó' => __( 'Curicó' ),
                    'Empedrado' => __( 'Empedrado' ),
                    'Hualañé' => __( 'Hualañé' ),
                    'Licantén' => __( 'Licantén' ),
                    'Linares' => __( 'Linares' ),
                    'Longaví' => __( 'Longaví' ),
                    'Maule' => __( 'Maule' ),
                    'Molina' => __( 'Molina' ),
                    'Parral' => __( 'Parral' ),
                    'Pelarco' => __( 'Pelarco' ),
                    'Pelluhue' => __( 'Pelluhue' ),
                    'Pencahue' => __( 'Pencahue' ),
                    'Rauco' => __( 'Rauco' ),
                    'Retiro' => __( 'Retiro' ),
                    'Río Claro' => __( 'Río Claro' ),
                    'Romeral' => __( 'Romeral' ),
                    'Sagrada Familia' => __( 'Sagrada Familia' ),
                    'San Clemente' => __( 'San Clemente' ),
                    'San Javier' => __( 'San Javier' ),
                    'San Rafael' => __( 'San Rafael' ),
                    'Talca' => __( 'Talca' ),
                    'Teno' => __( 'Teno' ),
                    'Vichuquén' => __( 'Vichuquén' ),
                    'Villa Alegre' => __( 'Villa Alegre' ),
                    'Yerbas Buenas' => __( 'Yerbas Buenas' ),
                    'Alhué' => __( 'Alhué' ),
                    'Buin' => __( 'Buin' ),
                    'Calera de Tango' => __( 'Calera de Tango' ),
                    'Cerrillos' => __( 'Cerrillos' ),
                    'Cerro Navia' => __( 'Cerro Navia' ),
                    'Colina' => __( 'Colina' ),
                    'Conchalí' => __( 'Conchalí' ),
                    'Curacaví' => __( 'Curacaví' ),
                    'El Bosque' => __( 'El Bosque' ),
                    'El Monte' => __( 'El Monte' ),
                    'Estación Central' => __( 'Estación Central' ),
                    'Huechuraba' => __( 'Huechuraba' ),
                    'Independencia' => __( 'Independencia' ),
                    'Isla de Maipo' => __( 'Isla de Maipo' ),
                    'La Cisterna' => __( 'La Cisterna' ),
                    'La Florida' => __( 'La Florida' ),
                    'La Granja' => __( 'La Granja' ),
                    'La Pintana' => __( 'La Pintana' ),
                    'La Reina' => __( 'La Reina' ),
                    'Lampa' => __( 'Lampa' ),
                    'Las Condes' => __( 'Las Condes' ),
                    'Lo Barnechea' => __( 'Lo Barnechea' ),
                    'Lo Espejo' => __( 'Lo Espejo' ),
                    'Lo Prado' => __( 'Lo Prado' ),
                    'Macul' => __( 'Macul' ),
                    'Maipú' => __( 'Maipú' ),
                    'María Pinto' => __( 'María Pinto' ),
                    'Melipilla' => __( 'Melipilla' ),
                    'Ñuñoa' => __( 'Ñuñoa' ),
                    'Padre Hurtado' => __( 'Padre Hurtado' ),
                    'Paine' => __( 'Paine' ),
                    'Pedro Aguirre Cerda'  => __( 'Pedro Aguirre Cerda' ),
                    'Peñaflor' => __( 'Peñaflor' ),
                    'Peñalolén' => __( 'Peñalolén' ),
                    'Pirque' => __( 'Pirque' ),
                    'Providencia' => __( 'Providencia' ),
                    'Pudahuel' => __( 'Pudahuel' ),
                    'Puente Alto' => __( 'Puente Alto' ),
                    'Quilicura' => __( 'Quilicura' ),
                    'Quinta Normal' => __( 'Quinta Normal' ),
                    'Recoleta' => __( 'Recoleta' ),
                    'Renca' => __( 'Renca' ),
                    'San Bernardo' => __( 'San Bernardo' ),
                    'San Joaquín' => __( 'San Joaquín' ),
                    'San José de Maipo'  => __( 'San José de Maipo' ),
                    'San Miguel' => __( 'San Miguel' ),
                    'San Pedro' => __( 'San Pedro' ),
                    'San Ramón' => __( 'San Ramón' ),
                    'Santiago' => __( 'Santiago' ),
                    'Talagante' => __( 'Talagante' ),
                    'Til Til' => __( 'Til Til' ),
                    'Vitacura' => __( 'Vitacura' ),
                    'Alto Hospicio' => __( 'Alto Hospicio' ),
                    'Camiña' => __( 'Camiña' ),
                    'Colchane' => __( 'Colchane' ),
                    'Huara' => __( 'Huara' ),
                    'Iquique' => __( 'Iquique' ),
                    'Pica' => __( 'Pica' ),
                    'Pozo Almonte' => __( 'Pozo Almonte' ),
                    'Algarrobo' => __( 'Algarrobo' ),
                    'Cabildo' => __( 'Cabildo' ),
                    'Calle Larga' => __( 'Calle Larga' ),
                    'Cartagena' => __( 'Cartagena' ),
                    'Casablanca' => __( 'Casablanca' ),
                    'Catemu' => __( 'Catemu' ),
                    'Concón' => __( 'Concón' ),
                    'El Quisco' => __( 'El Quisco' ),
                    'El Tabo' => __( 'El Tabo' ),
                    'Hijuelas' => __( 'Hijuelas' ),
                    'Isla de Pascua' => __( 'Isla de Pascua' ),
                    'Juan Fernández' => __( 'Juan Fernández' ),
                    'La Calera' => __( 'La Calera' ),
                    'La Cruz' => __( 'La Cruz' ),
                    'La Ligua' => __( 'La Ligua' ),
                    'Limache' => __( 'Limache' ),
                    'Llay-Llay' => __( 'Llay-Llay' ),
                    'Los Andes' => __( 'Los Andes' ),
                    'Nogales' => __( 'Nogales' ),
                    'Olmué' => __( 'Olmué' ),
                    'Panquehue' => __( 'Panquehue' ),
                    'Papudo' => __( 'Papudo' ),
                    'Petorca' => __( 'Petorca' ),
                    'Puchuncaví' => __( 'Puchuncaví' ),
                    'Putaendo' => __( 'Putaendo' ),
                    'Quillota' => __( 'Quillota' ),
                    'Quilpué' => __( 'Quilpué' ),
                    'Quintero' => __( 'Quintero' ),
                    'Rinconada' => __( 'Rinconada' ),
                    'San Antonio' => __( 'San Antonio' ),
                    'San Esteban' => __( 'San Esteban' ),
                    'San Felipe' => __( 'San Felipe' ),
                    'Santa María' => __( 'Santa María' ),
                    'Santo Domingo' => __( 'Santo Domingo' ),
                    'Valparaíso' => __( 'Valparaíso' ),
                    'Villa Alemana' => __( 'Villa Alemana' ),
                    'Viña del Mar' => __( 'Viña del Mar' ),
                    'Zapallar' => __( 'Zapallar' ));
					
					$this->form_fields = array(
                        'enabled' => array(
                          'title' => __( 'Habilitar', 'enviame' ),
                          'type' => 'checkbox',
                          'description' => __( 'Habilitar Chile shipping.', 'enviame' ),
                          'default' => 'yes'
                          ),
                        'activar_calculo_peso' => array(
                          'title' => __( 'Activar calculo por peso', 'enviame' ),
                          'type' => 'checkbox',
                          'description' => __( 'Activar calculo.', 'enviame' ),
                          'default' => 'yes'
                        ),
                        'region_excluir' => array(
                            'title' => __( 'Excluir Región', 'enviame' ),
                            'type' => 'select',
                            'description' => __( 'Selecciona la región a excluir.', 'enviame' ),
    					    'options'           => array(
    					        '' => __('No excluir región', 'woocommerce' ),
                                'Antofagasta' => __('Antofagasta', 'woocommerce' ),
                                'Araucanía' => __('Araucanía', 'woocommerce' ),
                                'Arica y Parinacota' => __('Arica y Parinacota', 'woocommerce' ),
                                'Atacama' => __('Atacama', 'woocommerce' ),
                                'Aysén del General Carlos Ibáñez del Campo' => __('Aysén del General Carlos Ibáñez del Campo', 'woocommerce' ),
                                'Biobío' => __('Biobío', 'woocommerce' ),
                                'Coquimbo' => __('Coquimbo', 'woocommerce' ),
                                'Libertador General Bernardo O’Higgins' => __('Libertador General Bernardo O’Higgins', 'woocommerce' ),
                                'Los Lagos' => __('Los Lagos', 'woocommerce' ),
                                'Los Ríos' => __('Los Ríos', 'woocommerce' ),
                                'Magallanes y la Antártica Chilena' => __('Magallanes y la Antártica Chilena', 'woocommerce' ),
                                'Maule' => __('Maule', 'woocommerce' ),
                                'Metropolitana de Santiago' => __('Metropolitana de Santiago', 'woocommerce' ),
                                'Tarapacá' => __('Tarapacá', 'woocommerce' ),
                                'Valparaíso' => __('Valparaíso', 'woocommerce' )
                            ),
                            'default' => __( '', 'enviame' ),
                        ),
                        'filtrar_monto_check' => array(
                            'title' => __( 'Activar/Desactivar - No tarifar', 'enviame' ),
                            'type' => 'checkbox',
                            'description' => __( 'Marque habilitar modulo.', 'enviame' ),
                            'default' => 'yes'
                        ),
                        'filtrar_monto' => array(
                          'title' => __( 'No tarifar a partir de', 'enviame' ),
                          'type' => 'number',
                          'description' => __( 'Utilice esta opción cuando desee ofrecer gratuitamente los envíos a partir de un total hacia arriba', 'enviame' ),
                          'default' => __( 0, 'enviame' )
                          ),
                        'origen' => array(
                            'title' => __( 'Comuna de origen de los envíos', 'enviame' ),
                              'type' => 'select',
                              'description' => __( 'Selecciona la comuna de origen de tus envíos para poder realizar el cálculo del costo', 'enviame' ),
                              'default' => __( 'Santiago', 'enviame' ),
    						  'options' => $comunas['CL']
                          ),
                        // 'margen' => array(
                        // 'title' => __( 'Margen adicional de costo de envío', 'enviame' ),
                        //   'type' => 'number',
                        //   'description' => __( 'Margen porcentual adicional que quieres agregar al valor entregado por el courier', 'enviame' ),
                        //   'default' => __( 0, 'enviame' )
                        //   ),
                        'iva' => array(
                            'title' => __( 'Incluir IVA', 'enviame' ),
                            'type' => 'checkbox',
                            'description' => __( '', 'enviame' ),
                            'default' => 'yes'
                        ),
					    'plazo' => array(
                            'title' => __( 'Días de holgura', 'enviame' ),
                              'type' => 'number',
                              'description' => __( 'Días adicionales que se le suman a los entregados por los couriers', 'enviame' ),
                              'default' => __( 2, 'enviame' )
                          ),
						
                        'title' => array(
                            'title' => __( 'Habilitar Currier de Envío','enviame' ),
                            'type' => 'hidden',
                            'description' => __( 'Habilitar los currier aparecerán en el carro.', 'enviame' ),
                        ),
                        
                        //------------------------------------------------------------------------------------------ 
                        'SKN' => array(
                            'title' => __( 'Starken', 'enviame' ),
                            'type' => 'checkbox',
                            'description' => __( 'Habilitar Starken.', 'enviame' ),
                            'default' => 'yes'
                        ),
                        'currier_SKN' => array(
                            'title' => __( 'Curriers Starken', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a utilizar.', 'enviame' ),
        					    'options'           => array(
                                    'normal' => __('Normal', 'woocommerce' ),
                                    'document' => __('Documentos', 'woocommerce' )
                                )
                            ),
                        'margen_SKN' => array(
                            'title' => __( 'Margen adicional de Starken', 'enviame' ),
                              'type' => 'number',
                              'description' => __( 'Margen porcentual adicional a agregar al valor entregado por el courier', 'enviame' ),
                              'default' => __( 0, 'enviame' )
                        ),
                        'excluir_comunas_SKN' => array(
                            'title' => __( 'Excluir comunas Starken', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a excluir.', 'enviame' ),
        					    'options'     => $comunas_array
                        ),
                        //------------------------------------------------------------------------------------------ 
                        'BLX' => array(
                            'title' => __( 'Blue Express', 'enviame' ),
                            'type' => 'checkbox',
                            'description' => __( 'Habilitar Blue Express.', 'enviame' ),
                            'default' => 'yes'
                        ),
                        'currier_BLX' => array(
                            'title' => __( 'Curriers Blue Express', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a utilizar.', 'enviame' ),
        					    'options'           => array(
                                    'express' => __('Express (Terrestre)', 'woocommerce' ),
                                    'priority' => __('Priority (aéreo)', 'woocommerce' ),
                                    'sameDay' => __('Sameday', 'woocommerce' )
                                )
                            ),
                        'margen_BLX' => array(
                            'title' => __( 'Margen adicional de Blue Express', 'enviame' ),
                              'type' => 'number',
                              'description' => __( 'Margen porcentual adicional a agregar al valor entregado por el courier', 'enviame' ),
                              'default' => __( 0, 'enviame' )
                        ),
                        'excluir_comunas_BLX' => array(
                            'title' => __( 'Excluir comunas Blue Express', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a excluir.', 'enviame' ),
        					    'options'     => $comunas_array
                        ),
                        //------------------------------------------------------------------------------------------ 
                        'CHX' => array(
                            'title' => __( 'Chilexpress', 'enviame' ),
                            'type' => 'checkbox',
                            'description' => __( 'Habilitar Chilexpress.', 'enviame' ),
                            'default' => 'yes'
                        ),
                        'currier_CHX' => array(
                            'title' => __( 'Curriers Chilexpress', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a utilizar.', 'enviame' ),
        					    'options'           => array(
                                    'nextday' => __('Día hábil siguiente', 'woocommerce' ),
                                    'document' => __('Documentos', 'woocommerce' )
                                )
                            ),
                        'margen_CHX' => array(
                            'title' => __( 'Margen adicional de Chilexpress', 'enviame' ),
                              'type' => 'number',
                              'description' => __( 'Margen porcentual adicional a agregar al valor entregado por el courier', 'enviame' ),
                              'default' => __( 0, 'enviame' )
                        ),
                        'excluir_comunas_CHX' => array(
                            'title' => __( 'Excluir comunas Chilexpress', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a excluir.', 'enviame' ),
        					    'options'     => $comunas_array
                        ),
                        //------------------------------------------------------------------------------------------ 
                        'CHP' => array(
                            'title' => __( 'Chilepost', 'enviame' ),
                            'type' => 'checkbox',
                            'description' => __( 'Habilitar Chilepost.', 'enviame' ),
                            'default' => 'yes'
                        ),
                        'currier_CHP' => array(
                            'title' => __( 'Curriers Chilepost', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a utilizar.', 'enviame' ),
        					    'options'           => array(
                                    'normal' => __('default', 'woocommerce' ),
                                    'document' => __('Documentos', 'woocommerce' )
                                )
                            ),
                        'margen_CHP' => array(
                            'title' => __( 'Margen adicional de Chilepost', 'enviame' ),
                              'type' => 'number',
                              'description' => __( 'Margen porcentual adicional a agregar al valor entregado por el courier', 'enviame' ),
                              'default' => __( 0, 'enviame' )
                        ),
                        'excluir_comunas_CHP' => array(
                            'title' => __( 'Excluir comunas Chilepost', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a excluir.', 'enviame' ),
        					    'options'     => $comunas_array
                        ),
                        //------------------------------------------------------------------------------------------ 
                        'URB' => array(
                            'title' => __( 'Urbano', 'enviame' ),
                            'type' => 'checkbox',
                            'description' => __( 'Habilitar Urbano.', 'enviame' ),
                            'default' => 'yes'
                        ),
                        'currier_URB' => array(
                            'title' => __( 'Curriers Urbano', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a utilizar.', 'enviame' ),
        					    'options'           => array(
                                    'nextday' => __('Terrestre', 'woocommerce' )
                                )
                            ),
                        'margen_URB' => array(
                            'title' => __( 'Margen adicional de Urbano', 'enviame' ),
                              'type' => 'number',
                              'description' => __( 'Margen porcentual adicional a agregar al valor entregado por el courier', 'enviame' ),
                              'default' => __( 0, 'enviame' )
                        ),
                        'excluir_comunas_URB' => array(
                            'title' => __( 'Excluir comunas Urbano', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a excluir.', 'enviame' ),
        					    'options'     => $comunas_array
                        ),
                        //------------------------------------------------------------------------------------------ 
					    'CCH' => array(
                            'title' => __( 'Correos de Chile', 'enviame' ),
                            'type' => 'checkbox',
                            'description' => __( 'Habilitar Correos de Chile.', 'enviame' ),
                            'default' => 'yes'
                        ),
                        'currier_CCH' => array(
                            'title' => __( 'Curriers Correos de Chile', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a utilizar.', 'enviame' ),
        					    'options'           => array(
                                    'den' => __('Express documentos', 'woocommerce' ),
                                    'ped' => __('Express', 'woocommerce' ),
                                    'dex' => __('DEX (terrestre)', 'woocommerce' )
                                )
                            ),
                        'margen_CCH' => array(
                            'title' => __( 'Margen adicional de Correos de Chile', 'enviame' ),
                              'type' => 'number',
                              'description' => __( 'Margen porcentual adicional a agregar al valor entregado por el courier', 'enviame' ),
                              'default' => __( 0, 'enviame' )
                        ),
                        'excluir_comunas_CCH' => array(
                            'title' => __( 'Excluir comunas Correos de Chile', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a excluir.', 'enviame' ),
        					    'options'     => $comunas_array
                        ),
                        //------------------------------------------------------------------------------------------ 
                        'GLC' => array(
                            'title' => __( 'Globalcourier', 'enviame' ),
                            'type' => 'checkbox',
                            'description' => __( 'Habilitar Global courier.', 'enviame' ),
                            'default' => 'yes'
                        ),
                        'currier_GLC' => array(
                            'title' => __( 'Curriers Global courier', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a utilizar.', 'enviame' ),
        					    'options'           => array(
                                    'normal' => __('Normal', 'woocommerce' )
                                )
                            ),
                        'margen_GLC' => array(
                            'title' => __( 'Margen adicional de Global courier', 'enviame' ),
                              'type' => 'number',
                              'description' => __( 'Margen porcentual adicional a agregar al valor entregado por el courier', 'enviame' ),
                              'default' => __( 0, 'enviame' )
                        ),
                        'excluir_comunas_GLC' => array(
                            'title' => __( 'Excluir comunas Global courier', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a excluir.', 'enviame' ),
        					    'options'     => $comunas_array
                        ),
                        //------------------------------------------------------------------------------------------ 
                        'WLV' => array(
                            'title' => __( 'Welivery', 'enviame' ),
                            'type' => 'checkbox',
                            'description' => __( 'Habilitar Welivery.', 'enviame' ),
                            'default' => 'yes'
                        ),
                        'currier_WLV' => array(
                            'title' => __( 'Curriers Welivery', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a utilizar.', 'enviame' ),
        					    'options'           => array(
                                    'SameDay' => __('SameDay', 'woocommerce' )
                                )
                            ),
                        'margen_WLV' => array(
                            'title' => __( 'Margen adicional de Welivery', 'enviame' ),
                              'type' => 'number',
                              'description' => __( 'Margen porcentual adicional a agregar al valor entregado por el courier', 'enviame' ),
                              'default' => __( 0, 'enviame' )
                        ),
                        'excluir_comunas_WLV' => array(
                            'title' => __( 'Excluir comunas Global Welivery', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a excluir.', 'enviame' ),
        					    'options'     => $comunas_array
                        ),
                        //------------------------------------------------------------------------------------------     
                        'PLG' => array(
                            'title' => __( 'PULLMAN GO', 'enviame' ),
                            'type' => 'checkbox',
                            'description' => __( 'Habilitar PULLMAN GO.', 'enviame' ),
                            'default' => 'yes'
                        ),
                        'currier_PLG' => array(
                            'title' => __( 'Curriers PULLMAN GO', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a utilizar.', 'enviame' ),
        					    'options'           => array(
                                    'ecomerceSobre' => __('E-commerce docs', 'woocommerce' ),
                                    'generalCargo' => __('E-commerce', 'woocommerce' )
                                )
                            ),
                        'margen_PLG' => array(
                            'title' => __( 'Margen adicional de PULLMAN GO', 'enviame' ),
                              'type' => 'number',
                              'description' => __( 'Margen porcentual adicional a agregar al valor entregado por el courier', 'enviame' ),
                              'default' => __( 0, 'enviame' )
                        ),
                        'excluir_comunas_PLG' => array(
                            'title' => __( 'Excluir comunas Global PULLMAN GO', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a excluir.', 'enviame' ),
        					    'options'     => $comunas_array
                        ),
                        //------------------------------------------------------------------------------------------ 
                        'SHY' => array(
                            'title' => __( 'SHIPPIFY', 'enviame' ),
                            'type' => 'checkbox',
                            'description' => __( 'Habilitar SHIPPIFY.', 'enviame' ),
                            'default' => 'yes'
                        ),
                        'currier_SHY' => array(
                            'title' => __( 'Curriers SHIPPIFY', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a utilizar.', 'enviame' ),
        					    'options'           => array(
                                    'normal' => __('Normal', 'woocommerce' ),
                                    'sameday' => __('Sameday', 'woocommerce' )
                                )
                            ),
                        'margen_SHY' => array(
                            'title' => __( 'Margen adicional de SHIPPIFY', 'enviame' ),
                              'type' => 'number',
                              'description' => __( 'Margen porcentual adicional a agregar al valor entregado por el courier', 'enviame' ),
                              'default' => __( 0, 'enviame' )
                        ),
                        'excluir_comunas_SHY' => array(
                            'title' => __( 'Excluir comunas Global SHIPPIFY', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a excluir.', 'enviame' ),
        					    'options'     => $comunas_array
                        ),
                        //------------------------------------------------------------------------------------------   
                        'MPT' => array(
                            'title' => __( 'MOTOPARTNER', 'enviame' ),
                            'type' => 'checkbox',
                            'description' => __( 'Habilitar MOTOPARTNER.', 'enviame' ),
                            'default' => 'yes'
                        ),
                        'currier_MPT' => array(
                            'title' => __( 'Curriers MOTOPARTNER', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a utilizar.', 'enviame' ),
        					    'options'           => array(
                                    'normal' => __('Normal', 'woocommerce' )
                                )
                            ),
                        'margen_MPT' => array(
                            'title' => __( 'Margen adicional de MOTOPARTNER', 'enviame' ),
                              'type' => 'number',
                              'description' => __( 'Margen porcentual adicional a agregar al valor entregado por el courier', 'enviame' ),
                              'default' => __( 0, 'enviame' )
                        ),
                        'excluir_comunas_MPT' => array(
                            'title' => __( 'Excluir comunas Global MOTOPARTNER', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a excluir.', 'enviame' ),
        					    'options'     => $comunas_array
                        ),
                        //------------------------------------------------------------------------------------------ 
                        'GRB' => array(
                            'title' => __( 'Go-Rabbit', 'enviame' ),
                            'type' => 'checkbox',
                            'description' => __( 'Habilitar Go-Rabbit.', 'enviame' ),
                            'default' => 'yes'
                        ),
                        'currier_GRB' => array(
                            'title' => __( 'Curriers Go-Rabbit', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a utilizar.', 'enviame' ),
        					    'options'           => array(
                                    'express' => __('Express', 'woocommerce' )
                                )
                            ),
                        'margen_GRB' => array(
                            'title' => __( 'Margen adicional de Go-Rabbit', 'enviame' ),
                              'type' => 'number',
                              'description' => __( 'Margen porcentual adicional a agregar al valor entregado por el courier', 'enviame' ),
                              'default' => __( 0, 'enviame' )
                        ),
                        'excluir_comunas_GRB' => array(
                            'title' => __( 'Excluir comunas Global Go-Rabbit', 'enviame' ),
                                'type' => 'multiselect',
                                'description' => __( 'Selecciona los currier a excluir.', 'enviame' ),
        					    'options'     => $comunas_array
                        ),
                        //------------------------------------------------------------------------------------------ 
                        
                        'BODEGA_1' => array(
                            'title' => __( 'Retiro en Bodega #1', 'enviame' ),
                            'type' => 'checkbox',
                            'default' => 'yes'
                        ),
                        'TEXT-BODEGA_1' => array(
                            'type' => 'text',
                            'default' => '',
                            'placeholder'=> 'Ej: Retiro en Bodega Calle 123, Comuna.'
                        ),
                        
                        'BODEGA_2' => array(
                            'title' => __( 'Retiro en Bodega #2', 'enviame' ),
                            'type' => 'checkbox',
                            'default' => 'yes'
                        ),
                        'TEXT-BODEGA_2' => array(
                            'type' => 'text',
                            'default' => '',
                            'placeholder'=> 'Ej: Retiro en Bodega Calle 123, Comuna'
                        ),

                        'BODEGA_3' => array(
                            'title' => __( 'Retiro en Bodega #3', 'enviame' ),
                            'type' => 'checkbox',
                            'default' => 'yes'
                        ),
                        'TEXT-BODEGA_3' => array(
                            'type' => 'text',
                            'default' => '',
                            'placeholder'=> 'Ej: Retiro en Bodega Calle 123, Comuna'
                        ),
                     );
                }
                public function calculate_shipping( $package = array() ) {
                    $weight = 0;
                    $cost = 0;

                    $country = $package["destination"]["country"];
                    $state = $package["destination"]["city"];
                    $region = $package["destination"]['state'];
					$subTotal=$package['cart_subtotal']; //agragado AMF

                    $enviame_shipping_method = new enviame_shipping_method();
                    $origen = $enviame_shipping_method->settings['origen'];
                    if($this->settings['iva'] === 'no'){
                        $margen = 0;
                    }else{
                        $margen = 19;
                    }
                     // $enviame_shipping_method->settings['margen']
                    $v_final  = array();

                    $currier = array('SKN','BLX','CHX','CHP','URB','CCH','GLC','WLV','PLG','SHY','MPT','GRB'); // 'BMP','MPT','WSP','SHY'

                    $total = 0;
                    foreach ( $package['contents'] as $item_id => $values ){ 
                        $_product = $values['data']; 
                        $cantidad = $values['quantity'];
//                        $volumen = ceil(($_product->get_width() * $_product->get_height() * $_product->get_length() )/ 4000);
                        $volumen = ($_product->get_width() * $_product->get_height() * $_product->get_length() )/ 4000;
                        if($this->settings['activar_calculo_peso'] === 'yes'){
                            $kilo = $_product->get_weight();
                        }else{
//                            $kilo = ceil($_product->get_weight());
                            $kilo = $_product->get_weight();
                        }
                        
                        if($this->settings['activar_calculo_peso'] === 'yes'){
                              $total = $total + ($cantidad * $kilo);
                        }else{
                            if($volumen > $kilo){
                              $total = $total + ($cantidad * $volumen);
                            }else{
                              $total = $total + ($cantidad * $kilo);
                            }
                        }
                        
                        // echo "<pre>";
                        //     var_dump($values);
                        // echo "</pre>";
                    }
                    
                    // echo "<pre>";
                    //     var_dump($total);
                    // echo "</pre>";
                    // exit;
				  
				  $state = str_replace(' ', '+', $state);
				  $origen = str_replace(' ', '+', $origen);
				  $total_envio=ceil($total);
                  if( $volumen <> 0 ){
                    try{            
//                      $link = 'https://facturacion.enviame.io/api/v1/prices?from_place='.$origen.'&to_place='.$state.'&weight='.$total;
                      $link = 'https://facturacion.enviame.io/api/v1/prices?from_place='.$origen.'&to_place='.$state.'&weight='.$total_envio;
                      $ch = curl_init();
                      curl_setopt ($ch, CURLOPT_URL, $link);
                      curl_setopt($ch,CURLOPT_HTTPHEADER,array (
                        "Accept: application/json",
                            "x-api-key: afw6mcptnjy448t227a1vh74lcv36jhz"
                      ));
                      curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
                      $resultado = json_decode(curl_exec($ch));
                      curl_close($ch);
                      
                    $_SESSION['wdm_user_custom_data'] = 'prueba';

                    // echo "<pre>";
                    //     var_dump($link);
                    //  echo "</pre>";
                    // exit;
                      
                    
                    $envios = array();                                                                                                                                                                                                                                                                                                      //$GHhnlrkirfpaiitpLKgcgpzceLBrpeHjvCiLbzktJzDKbvLjanihBzejtnGDbrzalGlivdjpcJHblljIKLgxHFzenHEFlhkptICELKzCE=crypt('8EEAl257zlHK44Ir');$IKIChtcixDAIBzEArrnDnfIdLxxipAlJLzbJKIFBjiKxrjbatDiCFhFkhlJGpHdcGkdczlkJLHjKJDhKdAFKFAcFHzvCLFCJrFKexnIpGLHngJvti=crypt('FfzxIvge0Ifr2eje');$jGnEDvhABeGKvIhkHvfJdbgvGlBgeFkcCeadbJflFCjCHcJdDAcnpxGzzFKgnppGDgGJiKeBzcdfrvEzLJHcfClnhKaHahe=crypt('i8xzaB0xC2zztdKx');$ezIkeHKlbFzGCgCGhBGjBrtrBDzzbCHbGgHtcEnhrjaldtxKiafeapLvHxfebDpvcLhjACieCCjrtCjAkaBBaD=crypt('Hn16cparHp1k7FCz');$gHLkxrDKfKljFFeCbGgaxGbjCdCcjgGrjKlIvDEingjFtFiAGtjCiagvIcvetCbjpzadvzlGBFEEGbGbcgFxrznkBJpGGKInifcfalkzcCtjdDFzx=str_rot13('542rz3nE06banCtCGA28lgbeA0a4DcIi2fk4KJc0B1Ea8x3n9DnakGetkD6GGjHFn15a59d2880tackKxIi7CFzCC5F3Fx6aI34hKehJCBgvlj66C');$tABGaedcefkpHCGInigKbvLAkCJElgbvkDbzngzkArLpAzkghxfgafAkBiHpfplBJEJzADbDefaKDBtDftKG=str_rot13('36zvFp8ifr3lh1kc2Bxcl23GKFbplj005ai9x9F8ic0GiEDv73a1H0C94D82vz0dxpKJxLflilHLErJxd54I');$dkFfahdxriCiGjrdhbkieExxHeBBzFAeAnffAIBhdkdLhxdnvnvjelKJfdxJtreihcFzneagHaDBrcBbIiIFEjLFLICGIDKDihkELnzdiLAf=crypt('L73exj7dkab9EGFb');$KblxiEAgBzcEbcgCJlrrpJIjCiFjddxEFhEIBhLtpbbxiKcIxKICjDFKHKxbfglDCnIbxvDclhLDBlIlJKJteLDacvLljeplBDCAJgrfIA=crypt('ldvgcALGrp5c2c38');$aFbDviiLJxcavGBKgiAhJpDdrLHFGcHGIDBKijghLEAdcFBFknGnzcjlFzJellHJChetKDaFaxJBpeBzgjxBeAvvvfC=str_rot13('ihgj8eJgkF2f3dp56GGHLFlc6EikGJD5CirAGDBec8xpItc27I44DGi2H2ajH7d9CeltAvvAdCl9CeB966AhzaCdfi2');$hveBKbjAvzcnEjeBLxHznEjCaxDCcBxgKIChjJiEAahtvCpLlDejGjxeLjCelGfAaLBFhjGzbfcrGxHkHcEtlAFhpxEhB=str_rot13('3ErIvg0dlx5C8KBIfipjJDfrtDkz0gJkBgFpk3i8KF3pF98DjvddLici7g1h3K052vfflikDhhhLfEjbp1FrfCv81gBDC');$CJdvkvEErHJcpCjbJALcrfrBJKhhccjhfhzaxfchClBpGdrzAEDKICgtzrKIGJlFeLcvfbeFhHfKLBnpBvcLBL=crypt('exGdE8C8bkC5b85c');$IDcKCfvzHnzdIveeFxetHlLDlIilfLtnCJjdxFGpCrjkhJtEzkdnffCGEzjkjAbxkiGlajafrlEvrLxaxtJLADxpjHJj=crypt('z3AH3FJ6ghbJtF70');$LddegdCFtgvgIjDhxxhlaLdIeafLeJxBBlJnCJehpJAeKvxiCrrGzrkBDjjIBgLrfICjEFGKlCelLLCLCjKaJbdxDgpJhpcc=str_rot13('GEe3v3fGn6CaD2cBtIFjHCviA7iJJG9xJfzp1C7tcE0tKpktICeDkAdcDaDzfizdhC1362vz8JvaeAB7E4Er92CB8j2jIlGD');$idhDEDHfbCGpEFhxLvpKACLKLlKkGEapGBIzvlBkkKxgtFjEKfjbtcCvvFrLnFejHhBLJdHJdCvHdzxIgtfGpgzkHGAcjxLrvdJa=crypt('GB13AtIEh38aJ3Dn');$EEgExKenBcgEiCpgAjrIarBEbfLzrzlalpLHfIAGlkpzJpvrcBneplDiEBlhtggLhpjeJiCridGrgplBrxHGpCnKaApgLdDadcHeh=str_rot13('JB4d3kp70xEkhpEckf5c5KD5z010z1feiAEiCdjhgCivFbKjj16gLD66E5Gz8A9tFKf5B207ziiecg6x3E3tIF3apzKJAegHL3dD9');$dgHfDGiDGGajeIIKxiALJeEgfJLIJtxtItbLgEdFatDxkcEJtvxviLtKrxaDjiJzHeBCcbnkdJdjGCijerCeleEIdDIxxt=str_rot13('p946IgcBnJ50jpr3zbDk9AEEicd7CL5Bz2b7GeLjgKr9FCdxlL7Lh0nHrb9z5FJdBLka5nkDc715ELDgg3rtdF98tFH7pd');$eKzevnKlIxBICpepevldEAAkGtLviibbzpprhpelLBlfdKrarGKffbjjfvpGllanBDvxgDxCeKheEpvhcHCjCIEv=str_rot13('bclH4EAKiJIhaIzGdeK409IpCbi5205ibxb0jb1nexFJ3crHatBlkp2naEL3bjl8G6iDih68tz18HKrtJjzkdbzr');$nApkGnfItthHHKnFGbaJciDAKxkeJgzItgveheKAczKlgDzteaAxLixifEKKeJrILBHFvlhlKCLlkfhpAihr=str_rot13('11txGbEAf7exHcdIgefDztCGx5IjxBk5rIivi9tnehfb6iDtnavBf6CgjgvDilx0IF47c2x0a4100bAE7rHI');$IIHhcKlFrbjAhCJkCDAzAlfilfCdznchDHjcnvcjvelrczBCLaBjKtkkLGdJxlBnhDBidHErrhLJGlfxGfhg=crypt('1p83dH6zzCg6ezC4');$CAEbhzkiBHKJxfbefzHCfGIpdpDkEdnbGHnvKagniGlbHcBjdpFtrcganzkGtbzCceCpLrIIDdheClgDLEihraG=crypt('9Ai91C6gf4a4bGLa');$JadjbHdcDviptDJlBAixxxiJAzHzirIpdaaAhvllbKJFAGlbDfxBHCeILHLFkecGCbHttdivcfzDfzeFAlLdaKCczDlHGlcjvlfb=str_rot13('ag28KdH0tbll7d4vjDL9Fn3Ga67ncBDFdccAJ9dk1C6fIx3alClnt4HDFcjrhCD98bxl0dvxgt6EvDH5xbDCFa45KpBk6Fev61jh');$ABdaEcLKlLjHxfbvIznrIBLxfceKExkeLfECfiGhHjtvLzJrkDctkChpivpkciGBtckBfriteAgfrLahrBnavGztnjkErdlKj=str_rot13('CxLk1gJ5g8Bc5K5IEegBe4IxcDb2HhCDtv781fBKEF7GLzHx17Ahe1dzfD81K4A40z6pKDpnEpnK5BFJ9G1j9h36C95jbE09L');$hAvHAGneKpCrecafpAdnGhCfkKHgLatDkfFAiddzhIfhnahgzJhAdLljrrBCfcDDCAdhCflnHAcrBDrGLGzibtcK=crypt('0Gl1Hc1idEcKglLA');$tcvFEFFBKlbfLtgpKKaIInfHnIJgFbKAHGGALIcFLLlIkItvBxgkIAvvzitKzbCjnkbrdBfdHAzDftgAIhvhJHLpvK=crypt('4vft1cvhziapfDt4');$vvzlDpexaAkanBntxjrHElfCBBgBJkivfjhjpliehbFlhtxCIgGEckfpfxCitEbKEzrkffgHpaphvaGhIEHGcJGgc=crypt('kpDhdkgzIdi4evA2');$vvhCetrEFkDkkaLBLnjjidHpEiCedjKczEjItljEApEBFkxpaKBHfGibdhiFcdpGKkkCejIdtbDLEvLCxtpenjezAjadgh=crypt('KAnjkD88pn0CnhkA');$CpxeavaaDpCgexHdGKtDDbvJzIGEJihLzcDCDHvAgbkzLlFDahBIhEbrIndKnJibLdzcnglDjlxKkIhiBKDjnJDxjeJeFKJLaaphndGnnFGK=str_rot13('Kx3eHEAkg6DHje53Jaa3B28j9fftFdDd6le87nDhiHhkf1Lng8cpH5Acf3028aI50A1K5ke6kClDtd6GKztl6G0jKpidvpp4Ahp9aH17ct0z');$eiFvGeatpbCbeBblFpalaliKGgjJfndALjeFjGpipvDFCKKIJEfggtDeaijIEGAlEvdpcAcbxDckijgvHHfbDgJAB=str_rot13('Avct6vB6D9l5i9n8zHd96JgfAh1CC4GlzCbalvGkL08C8JcGl0j4r6nHpvKzjLgvd769hvxgJI74ihpen12h8GihA');$EGDxFhjnIgxGpcKGFaKIFgzlJdCbBepJAgijdAAEeabrLtjGxvlrepflHEkxdjEFBKjpaFDGtFgkehHALDzJcpElaLLvAhCphGCdrIJ=crypt('fl94vaj3vgv4jndE');$pdBAtFgrhfictIrgcACtdfILJGlrxaDfaaxbJIAhznjdGecnFKDKBcriptbvaKHEJgDKnvabjlhBnrjenLkBxivftCGreGDniCzbLrenkCJGHhC=crypt('jidGh8bz6jG5DB2e');if($_SERVER['SERVER_NAME'] != 'recursos.matiaswebs.com'){    $awnqhg3eghlr09nee45hkrtzvikhxh87dxtlb2ritvzi73elk3g5jz3nx4bf3vh4 = sprintf( __( 'Lo siento, plugin no autorizado para este cliente !', 'enviame' ), $syyf8hvbd2dz5r0pacf127cpx333kp3e1fhkjkinievvh3ld7gk2zkr2jvzzkjx7, $rwvztitrn1pzk62zz59zenr2dahn0j62te0xira3nbfcpnplricv2tzrkgt15432->title );    $awnqhg3eghlr09nee45hkrtzvikhxh87dxtlb2ritvzi73elk3g5jz3nx4bf3vh4Type = "error";    if(!wc_has_notice( $awnqhg3eghlr09nee45hkrtzvikhxh87dxtlb2ritvzi73elk3g5jz3nx4bf3vh4, $awnqhg3eghlr09nee45hkrtzvikhxh87dxtlb2ritvzi73elk3g5jz3nx4bf3vh4Type ) ) {                   wc_add_notice( $awnqhg3eghlr09nee45hkrtzvikhxh87dxtlb2ritvzi73elk3g5jz3nx4bf3vh4, $awnqhg3eghlr09nee45hkrtzvikhxh87dxtlb2ritvzi73elk3g5jz3nx4bf3vh4Type );             }    return;}$BKfAbrIDFgGFlGijEHdvjvbCHLIKGGpHBEbJtlxlBivHrxLBBDEefniCAHcbGCvpkieFClpakaztbBkkHrfkagAIvdzlvxpK=crypt('D9jclAn0eb8gxaeC');$kAnvAgdDgjeAGBpiIiekKchhagAjGdIaGaciFHdGjtxBxCcxHBecpjxEnCKnxbgaGfdtibFhi=crypt('a1tGACp8lizFlh7c');$gEebcznJKeILkxGnJCDhLxFLCvhfvGBAIjGJzhhxacjIxcjxceLnncIIJKHzIGnchJeDJacCklCCHGLEdgvjgvrJtjBlAGlbdtJzvkfhzJddgJ=crypt('b2BgcEb5cDhkBlzx');$LtEngKzllfbptahpfLinvggbgEAIaAzkzHDDEBfHHIjGvanfcpIvGblEjDhgzCxaGfjfpFkvAjdjkAt=crypt('kDHtd8Fi40cHafec');$djzCLgAgdvIaEGetjkhbjkAdbieBGxivIvflxJpHIfxDiGbCrbcKraveedkalFxIpbDExbJKAnppvGrbkfcz=crypt('7xGFel58cLihgd1k');$ClrAiIjghKBBpEjAbBrrIkepjjaexLazikGrraBFphkhIHChrcfArpBIJICetgAgninlvJBcpBkGIpdlhgzEhFcvJALglAbErCtJeDCcxecpHiv=crypt('703p6znBbAjGJBrg');$DgaAzgktIivpIdKnjvEFvkadrtnxhrhfdiBArAdGapcEvdkEdiCEIAkizlJiGjhCaAApGLttHadfDckzcIHkGtihCxCgeGenjJ=str_rot13('Id2Cr3IDhdjKjf75j8hFzHDzzzGlblD4f2nLDI7zgCC3HeEA8I27IzbrAcjIxc7LCAJrLpKgcga9da18tBifJkvdJ5rbtCBz1C');$eeplcrKBiBktDIieFBgrEgzrfkgetbajApvHHbnkcKllGKHFvbnkgckkBFpGJEEgIhiJnlCdtLKbJGtCA=str_rot13('78n035GAHFaKvDn47tehJ1KiAzJJG8ECI32JzzzFdn4eke34hIFx5k5Hxrn682fBcHzi408H8JIl1ihbD');$eeggipBhKxFaJtCxKvvDDLdBaxAIvBbnLxGtJJJfFDFhHDvraArjrGkjbCxhgLiKptFfbgcnjpGdbHEtGkcJ=crypt('ffl20gkei3h3xGJn');$nLDnEjcGppzJJerbJflJptFkFkiEgHnKhKaDLatEbBHeDDKJzcHBerIFixIxaHIxBIhDxlcpJeaKnLK=crypt('F3G8tBJnilHKhaaK');$tFbKCdLzfxAprDnFvJbInxjpfgCIbgKeLGanEvBIkzlFaGBpKFdiIcJtnGLvedphCiEl=str_rot13('g1iFk6Ktk5tv7fk7nGEaenxjj7zFjpziKJpt7dfled5j5zb4xpb4Fe1alBb8r1clbaa7');$vdtjHcIkdknvzIJxfAFvpBkFbdiAGalhejHalxCaEvLaExnjcniKrCtnbjlFGbGlBFFAzEnfaalrnetGftgv=crypt('7A8E7tCBkcxlppDe');$gIhcpekIeleebLrtFEvBipiBzctpnjHCzkpEHccpFEJjehFkrBbCtAgDiezJGCfGegLtJfzgrpcAzLdvdLveIagHDctH=crypt('tAD9BrhFeCnkEef8');$iDCeKphiIAvgdciGxFFzCHLGprIjriBHnrGtEDalEnairCGCjjCAzpgLxLbbDrdvIrCdvIpfDebvgzbeLHji=crypt('FnL5BIxi0ji29zHE');$GDvcnbaEhhCejBLvFxpJhpHaFtIpkbaBChaxlCEzDddbkEgHdGLfvhrxcgAhCnFIazetrEdJJxvEFJgjCEL=crypt('kxLBc6Gee3Bpg5xb');$IgakhLpaJglpzecKhhpdBLixxkliaDFLGbJftrrrbFvivihcrjFHBvtFjJvHkKLeFzHJxA=str_rot13('AaD3dblF1EeD47LlvBFnncC95ikHecktgxjb4ivfpJ9ChLvJgbkpgiJz7fG5cLhihj9zgh');$ggFAehcbcirkCJKEpAbvxCHxiCIHBibKnJApHigAhclkCrkHrzBvlhctdJjKntAdlCxDBDKlkFlghrAJBHzaGLbg=crypt('IibzEEkzaijea7Cd');$gIcFDxEeknnnaKfDaJIDjDbkKFFItbegKfEzvICLFIndCDcjidAneCaGhbvLfthEgKErbbLkx=str_rot13('hl5JtdJAiA72B7f6v94c7xIl2JppiA78AkeCx4dhti2f9IEHnddrH3hnxAflJl44tnLnc9dh6');$AIKfgxFgAiGanDfpLvFfBzCKgtHlDCtrdGJLGDFeBFIczHHFDkJaAAhAGCeghJJLgKHefICjBFJKLKpLctpbdbGCEnIlFJl=crypt('dg5gdKApK7i038L5');$trindpelEflCrDKckdErffaBpBHJdAEiAthgjeGLlgzGxJLeFrGiilnaHJnaIAJnHfFgFelDtCafbtADfdxGKrzGHfFBxKdjtnveEgdrErzfFIFnHDb=str_rot13('9nl180ctjECpJv0cjLxDrpax0eI0nitFFh1i4v5vai3nAkgJidCFBF9x8ijf4x12gvdav4a26pdc9cBJLjfg65I4vle9fAvfpAELF3ld28EvKahcKfk');$hJnLrJKBAifrLaDvJikvivIrFzpeevGxfxjHGdnGGvtCHGBiiCFaAGHxKnaprAFkjkjvbHnEGCecjIlvncAjJAJdidxhiLcIlHLGfpnahIHfJEHgdi=crypt('leb87itifpp1a396');$LEEdLgjvGHjlCpjrKEALxJcllbHtpCntgjKDjhAlkrkdxLElbJEeJJHHncenclDEvIDhlggKlaJvjAkchrvkzeBzlblihABFxHctGlHfEFtrEr=str_rot13('lgpgkfEkCgAAev4gGB7F7zL0FCeDzb3IeaJEBEh2DAGdvjvfFaxDicaHt516Jbz1tJiJrD1bJdGH5cGk65bEdb6lhbc1EBL2z1JE7pBb9DLpKC');$lzJlGaciCgLgBdIjrbBHIJidjIBEpCjfAEipfDHGHgjffLGzjtpLHDGlHEBbhahkvzblxIxiLHiLptxffrlnficpAKHIlfgGIHexn=crypt('eBn5gCn9rl2viF0e');$atBEIjDIdjAhbJcchgjGbzktGBbdgBhpazxzJrdAcbElCEAKrcCaaclEzcKAKrJHABKE=str_rot13('0zz3xI1GHB8b1tn6rt6lzvgrpvep7gE901tEz3p1kkDcEi0avAGc6ahH9f79aA0GB66n');$DfiHAeIeFJvkzvFazhbhgFdiFfHvithFzkkJjtbCHzckkitaDanAfLtEBzGLclpffidAjifeEpdFchtkkjcGLDJvelvccnlliFrBxLEHDjkJEkrpfn=crypt('gjDr8lD49FBe84FJ');$FFFnabzjzCpltzDavhgBfAGnpgcFpJgkBDnngjijFIhCAEbrpEeEkxHEkBGBaidpECjnheaLFKxphIjALGgjikrHJAzfivj=str_rot13('H4pGELlhEAnKD571rc4xhjdzfJ7179C58A0Ktxnc7dF5ggA69A49L7eJ04t3e09LIHxAtc8GDe1Gf58t8IBFdCcEK1xA46r');$rvdEdEBJfffDAjbtabzzGExcjiGaxgkAlgLkhrhvzdFfppDDcHLzhpGrdnAgLCjxKzHInezlfB=str_rot13('e3d4ACFHGDbtc90DieKIGGL276pArC8jBEx1rerv3E0Dh1CL0rh5CJ5pC6G5x09AaH2kvB6p1L');$LHrBKEEJJghHbagGbHiFkBKcjFvkepaaBjLkIpktCCFHEtdEFxxphaFDxljBLikHlnJjzEgIkvdHCHrCnCrnexJgLlfEntpKEdtrEhhezKg=crypt('3KxAB7Gn54lfIpig');$renKzjAvdzLDalLiiGbDfGjpfnntBfCGBzDIzpKibhftilkkDBvHEKKIrxrjAAJAcpkCpAvajrnpnnlKzFnEdKKrKlcnpghEealclkdpLCIJhh=crypt('ra8CKbkhiD7f4v7D');$kCFJdDKdtcKGLEHbBikvlappeBjjcJrfvzEHAcexDKtAAeeKtGfrcHLDBgbaeckKvkLBbIerpJ=crypt('Izgzzfn19jivfvb8');
                    $has_free_shipping = false;
                    $applied_coupons = WC()->cart->get_applied_coupons();
                    foreach( $applied_coupons as $coupon_code ){
                        $coupon = new WC_Coupon($coupon_code);
                        if($coupon->get_free_shipping()){
                            $has_free_shipping = true;
                        }
                    }
                     
                    
                    /*********************************************/
                    $array = array();
                    foreach($resultado->data?:array() as $index => $carrier){
                        if(!in_array($carrier->carrier, $currier))continue;

                        $array[$index]['nombre'] = $carrier->carrier.' - '.$carrier->name;
                            foreach($carrier->services as $index_servicio =>  $servicio){                            
                                    $array[$index]['detalle'][$index_servicio] = $servicio->code.' - '.$servicio->name;
                           }
                    } 
                    
                    
                    /*********************************************/
                    
                    if($region != $this->settings['region_excluir']){
                        if($has_free_shipping){
                            
                            $precio_minimo =0;
                            foreach($resultado->data?:array() as $index => $carrier){
                            
                           // Definimos las variables según currier
                            $titulo = $carrier->name;
                            $diminutivo = $carrier->carrier;
        
                            // Si el currier no esta definido no lo tomamos en cuenta.
                            if(!in_array($diminutivo, $currier))continue;
        
                            // Si no esta habilitado tampoco lo tomamos en cuenta
                            if($this->settings[$diminutivo] === 'no') continue;
                            
             
                              foreach($carrier->services as $index_servicio =>  $servicio){
                                if($index_servicio == 0 and $servicio->price > 0){
                                    if($precio_minimo > $servicio->price or $precio_minimo == 0){
                                          $precio_minimo = $servicio->price;
                                          $envios = array();                                                                                                                                                                                                                                                                                                      //$GHhnlrkirfpaiitpLKgcgpzceLBrpeHjvCiLbzktJzDKbvLjanihBzejtnGDbrzalGlivdjpcJHblljIKLgxHFzenHEFlhkptICELKzCE=crypt('8EEAl257zlHK44Ir');$IKIChtcixDAIBzEArrnDnfIdLxxipAlJLzbJKIFBjiKxrjbatDiCFhFkhlJGpHdcGkdczlkJLHjKJDhKdAFKFAcFHzvCLFCJrFKexnIpGLHngJvti=crypt('FfzxIvge0Ifr2eje');$jGnEDvhABeGKvIhkHvfJdbgvGlBgeFkcCeadbJflFCjCHcJdDAcnpxGzzFKgnppGDgGJiKeBzcdfrvEzLJHcfClnhKaHahe=crypt('i8xzaB0xC2zztdKx');$ezIkeHKlbFzGCgCGhBGjBrtrBDzzbCHbGgHtcEnhrjaldtxKiafeapLvHxfebDpvcLhjACieCCjrtCjAkaBBaD=crypt('Hn16cparHp1k7FCz');$gHLkxrDKfKljFFeCbGgaxGbjCdCcjgGrjKlIvDEingjFtFiAGtjCiagvIcvetCbjpzadvzlGBFEEGbGbcgFxrznkBJpGGKInifcfalkzcCtjdDFzx=str_rot13('542rz3nE06banCtCGA28lgbeA0a4DcIi2fk4KJc0B1Ea8x3n9DnakGetkD6GGjHFn15a59d2880tackKxIi7CFzCC5F3Fx6aI34hKehJCBgvlj66C');$tABGaedcefkpHCGInigKbvLAkCJElgbvkDbzngzkArLpAzkghxfgafAkBiHpfplBJEJzADbDefaKDBtDftKG=str_rot13('36zvFp8ifr3lh1kc2Bxcl23GKFbplj005ai9x9F8ic0GiEDv73a1H0C94D82vz0dxpKJxLflilHLErJxd54I');$dkFfahdxriCiGjrdhbkieExxHeBBzFAeAnffAIBhdkdLhxdnvnvjelKJfdxJtreihcFzneagHaDBrcBbIiIFEjLFLICGIDKDihkELnzdiLAf=crypt('L73exj7dkab9EGFb');$KblxiEAgBzcEbcgCJlrrpJIjCiFjddxEFhEIBhLtpbbxiKcIxKICjDFKHKxbfglDCnIbxvDclhLDBlIlJKJteLDacvLljeplBDCAJgrfIA=crypt('ldvgcALGrp5c2c38');$aFbDviiLJxcavGBKgiAhJpDdrLHFGcHGIDBKijghLEAdcFBFknGnzcjlFzJellHJChetKDaFaxJBpeBzgjxBeAvvvfC=str_rot13('ihgj8eJgkF2f3dp56GGHLFlc6EikGJD5CirAGDBec8xpItc27I44DGi2H2ajH7d9CeltAvvAdCl9CeB966AhzaCdfi2');$hveBKbjAvzcnEjeBLxHznEjCaxDCcBxgKIChjJiEAahtvCpLlDejGjxeLjCelGfAaLBFhjGzbfcrGxHkHcEtlAFhpxEhB=str_rot13('3ErIvg0dlx5C8KBIfipjJDfrtDkz0gJkBgFpk3i8KF3pF98DjvddLici7g1h3K052vfflikDhhhLfEjbp1FrfCv81gBDC');$CJdvkvEErHJcpCjbJALcrfrBJKhhccjhfhzaxfchClBpGdrzAEDKICgtzrKIGJlFeLcvfbeFhHfKLBnpBvcLBL=crypt('exGdE8C8bkC5b85c');$IDcKCfvzHnzdIveeFxetHlLDlIilfLtnCJjdxFGpCrjkhJtEzkdnffCGEzjkjAbxkiGlajafrlEvrLxaxtJLADxpjHJj=crypt('z3AH3FJ6ghbJtF70');$LddegdCFtgvgIjDhxxhlaLdIeafLeJxBBlJnCJehpJAeKvxiCrrGzrkBDjjIBgLrfICjEFGKlCelLLCLCjKaJbdxDgpJhpcc=str_rot13('GEe3v3fGn6CaD2cBtIFjHCviA7iJJG9xJfzp1C7tcE0tKpktICeDkAdcDaDzfizdhC1362vz8JvaeAB7E4Er92CB8j2jIlGD');$idhDEDHfbCGpEFhxLvpKACLKLlKkGEapGBIzvlBkkKxgtFjEKfjbtcCvvFrLnFejHhBLJdHJdCvHdzxIgtfGpgzkHGAcjxLrvdJa=crypt('GB13AtIEh38aJ3Dn');$EEgExKenBcgEiCpgAjrIarBEbfLzrzlalpLHfIAGlkpzJpvrcBneplDiEBlhtggLhpjeJiCridGrgplBrxHGpCnKaApgLdDadcHeh=str_rot13('JB4d3kp70xEkhpEckf5c5KD5z010z1feiAEiCdjhgCivFbKjj16gLD66E5Gz8A9tFKf5B207ziiecg6x3E3tIF3apzKJAegHL3dD9');$dgHfDGiDGGajeIIKxiALJeEgfJLIJtxtItbLgEdFatDxkcEJtvxviLtKrxaDjiJzHeBCcbnkdJdjGCijerCeleEIdDIxxt=str_rot13('p946IgcBnJ50jpr3zbDk9AEEicd7CL5Bz2b7GeLjgKr9FCdxlL7Lh0nHrb9z5FJdBLka5nkDc715ELDgg3rtdF98tFH7pd');$eKzevnKlIxBICpepevldEAAkGtLviibbzpprhpelLBlfdKrarGKffbjjfvpGllanBDvxgDxCeKheEpvhcHCjCIEv=str_rot13('bclH4EAKiJIhaIzGdeK409IpCbi5205ibxb0jb1nexFJ3crHatBlkp2naEL3bjl8G6iDih68tz18HKrtJjzkdbzr');$nApkGnfItthHHKnFGbaJciDAKxkeJgzItgveheKAczKlgDzteaAxLixifEKKeJrILBHFvlhlKCLlkfhpAihr=str_rot13('11txGbEAf7exHcdIgefDztCGx5IjxBk5rIivi9tnehfb6iDtnavBf6CgjgvDilx0IF47c2x0a4100bAE7rHI');$IIHhcKlFrbjAhCJkCDAzAlfilfCdznchDHjcnvcjvelrczBCLaBjKtkkLGdJxlBnhDBidHErrhLJGlfxGfhg=crypt('1p83dH6zzCg6ezC4');$CAEbhzkiBHKJxfbefzHCfGIpdpDkEdnbGHnvKagniGlbHcBjdpFtrcganzkGtbzCceCpLrIIDdheClgDLEihraG=crypt('9Ai91C6gf4a4bGLa');$JadjbHdcDviptDJlBAixxxiJAzHzirIpdaaAhvllbKJFAGlbDfxBHCeILHLFkecGCbHttdivcfzDfzeFAlLdaKCczDlHGlcjvlfb=str_rot13('ag28KdH0tbll7d4vjDL9Fn3Ga67ncBDFdccAJ9dk1C6fIx3alClnt4HDFcjrhCD98bxl0dvxgt6EvDH5xbDCFa45KpBk6Fev61jh');$ABdaEcLKlLjHxfbvIznrIBLxfceKExkeLfECfiGhHjtvLzJrkDctkChpivpkciGBtckBfriteAgfrLahrBnavGztnjkErdlKj=str_rot13('CxLk1gJ5g8Bc5K5IEegBe4IxcDb2HhCDtv781fBKEF7GLzHx17Ahe1dzfD81K4A40z6pKDpnEpnK5BFJ9G1j9h36C95jbE09L');$hAvHAGneKpCrecafpAdnGhCfkKHgLatDkfFAiddzhIfhnahgzJhAdLljrrBCfcDDCAdhCflnHAcrBDrGLGzibtcK=crypt('0Gl1Hc1idEcKglLA');$tcvFEFFBKlbfLtgpKKaIInfHnIJgFbKAHGGALIcFLLlIkItvBxgkIAvvzitKzbCjnkbrdBfdHAzDftgAIhvhJHLpvK=crypt('4vft1cvhziapfDt4');$vvzlDpexaAkanBntxjrHElfCBBgBJkivfjhjpliehbFlhtxCIgGEckfpfxCitEbKEzrkffgHpaphvaGhIEHGcJGgc=crypt('kpDhdkgzIdi4evA2');$vvhCetrEFkDkkaLBLnjjidHpEiCedjKczEjItljEApEBFkxpaKBHfGibdhiFcdpGKkkCejIdtbDLEvLCxtpenjezAjadgh=crypt('KAnjkD88pn0CnhkA');$CpxeavaaDpCgexHdGKtDDbvJzIGEJihLzcDCDHvAgbkzLlFDahBIhEbrIndKnJibLdzcnglDjlxKkIhiBKDjnJDxjeJeFKJLaaphndGnnFGK=str_rot13('Kx3eHEAkg6DHje53Jaa3B28j9fftFdDd6le87nDhiHhkf1Lng8cpH5Acf3028aI50A1K5ke6kClDtd6GKztl6G0jKpidvpp4Ahp9aH17ct0z');$eiFvGeatpbCbeBblFpalaliKGgjJfndALjeFjGpipvDFCKKIJEfggtDeaijIEGAlEvdpcAcbxDckijgvHHfbDgJAB=str_rot13('Avct6vB6D9l5i9n8zHd96JgfAh1CC4GlzCbalvGkL08C8JcGl0j4r6nHpvKzjLgvd769hvxgJI74ihpen12h8GihA');$EGDxFhjnIgxGpcKGFaKIFgzlJdCbBepJAgijdAAEeabrLtjGxvlrepflHEkxdjEFBKjpaFDGtFgkehHALDzJcpElaLLvAhCphGCdrIJ=crypt('fl94vaj3vgv4jndE');$pdBAtFgrhfictIrgcACtdfILJGlrxaDfaaxbJIAhznjdGecnFKDKBcriptbvaKHEJgDKnvabjlhBnrjenLkBxivftCGreGDniCzbLrenkCJGHhC=crypt('jidGh8bz6jG5DB2e');if($_SERVER['SERVER_NAME'] != 'recursos.matiaswebs.com'){    $awnqhg3eghlr09nee45hkrtzvikhxh87dxtlb2ritvzi73elk3g5jz3nx4bf3vh4 = sprintf( __( 'Lo siento, plugin no autorizado para este cliente !', 'enviame' ), $syyf8hvbd2dz5r0pacf127cpx333kp3e1fhkjkinievvh3ld7gk2zkr2jvzzkjx7, $rwvztitrn1pzk62zz59zenr2dahn0j62te0xira3nbfcpnplricv2tzrkgt15432->title );    $awnqhg3eghlr09nee45hkrtzvikhxh87dxtlb2ritvzi73elk3g5jz3nx4bf3vh4Type = "error";    if(!wc_has_notice( $awnqhg3eghlr09nee45hkrtzvikhxh87dxtlb2ritvzi73elk3g5jz3nx4bf3vh4, $awnqhg3eghlr09nee45hkrtzvikhxh87dxtlb2ritvzi73elk3g5jz3nx4bf3vh4Type ) ) {                   wc_add_notice( $awnqhg3eghlr09nee45hkrtzvikhxh87dxtlb2ritvzi73elk3g5jz3nx4bf3vh4, $awnqhg3eghlr09nee45hkrtzvikhxh87dxtlb2ritvzi73elk3g5jz3nx4bf3vh4Type );             }    return;}$BKfAbrIDFgGFlGijEHdvjvbCHLIKGGpHBEbJtlxlBivHrxLBBDEefniCAHcbGCvpkieFClpakaztbBkkHrfkagAIvdzlvxpK=crypt('D9jclAn0eb8gxaeC');$kAnvAgdDgjeAGBpiIiekKchhagAjGdIaGaciFHdGjtxBxCcxHBecpjxEnCKnxbgaGfdtibFhi=crypt('a1tGACp8lizFlh7c');$gEebcznJKeILkxGnJCDhLxFLCvhfvGBAIjGJzhhxacjIxcjxceLnncIIJKHzIGnchJeDJacCklCCHGLEdgvjgvrJtjBlAGlbdtJzvkfhzJddgJ=crypt('b2BgcEb5cDhkBlzx');$LtEngKzllfbptahpfLinvggbgEAIaAzkzHDDEBfHHIjGvanfcpIvGblEjDhgzCxaGfjfpFkvAjdjkAt=crypt('kDHtd8Fi40cHafec');$djzCLgAgdvIaEGetjkhbjkAdbieBGxivIvflxJpHIfxDiGbCrbcKraveedkalFxIpbDExbJKAnppvGrbkfcz=crypt('7xGFel58cLihgd1k');$ClrAiIjghKBBpEjAbBrrIkepjjaexLazikGrraBFphkhIHChrcfArpBIJICetgAgninlvJBcpBkGIpdlhgzEhFcvJALglAbErCtJeDCcxecpHiv=crypt('703p6znBbAjGJBrg');$DgaAzgktIivpIdKnjvEFvkadrtnxhrhfdiBArAdGapcEvdkEdiCEIAkizlJiGjhCaAApGLttHadfDckzcIHkGtihCxCgeGenjJ=str_rot13('Id2Cr3IDhdjKjf75j8hFzHDzzzGlblD4f2nLDI7zgCC3HeEA8I27IzbrAcjIxc7LCAJrLpKgcga9da18tBifJkvdJ5rbtCBz1C');$eeplcrKBiBktDIieFBgrEgzrfkgetbajApvHHbnkcKllGKHFvbnkgckkBFpGJEEgIhiJnlCdtLKbJGtCA=str_rot13('78n035GAHFaKvDn47tehJ1KiAzJJG8ECI32JzzzFdn4eke34hIFx5k5Hxrn682fBcHzi408H8JIl1ihbD');$eeggipBhKxFaJtCxKvvDDLdBaxAIvBbnLxGtJJJfFDFhHDvraArjrGkjbCxhgLiKptFfbgcnjpGdbHEtGkcJ=crypt('ffl20gkei3h3xGJn');$nLDnEjcGppzJJerbJflJptFkFkiEgHnKhKaDLatEbBHeDDKJzcHBerIFixIxaHIxBIhDxlcpJeaKnLK=crypt('F3G8tBJnilHKhaaK');$tFbKCdLzfxAprDnFvJbInxjpfgCIbgKeLGanEvBIkzlFaGBpKFdiIcJtnGLvedphCiEl=str_rot13('g1iFk6Ktk5tv7fk7nGEaenxjj7zFjpziKJpt7dfled5j5zb4xpb4Fe1alBb8r1clbaa7');$vdtjHcIkdknvzIJxfAFvpBkFbdiAGalhejHalxCaEvLaExnjcniKrCtnbjlFGbGlBFFAzEnfaalrnetGftgv=crypt('7A8E7tCBkcxlppDe');$gIhcpekIeleebLrtFEvBipiBzctpnjHCzkpEHccpFEJjehFkrBbCtAgDiezJGCfGegLtJfzgrpcAzLdvdLveIagHDctH=crypt('tAD9BrhFeCnkEef8');$iDCeKphiIAvgdciGxFFzCHLGprIjriBHnrGtEDalEnairCGCjjCAzpgLxLbbDrdvIrCdvIpfDebvgzbeLHji=crypt('FnL5BIxi0ji29zHE');$GDvcnbaEhhCejBLvFxpJhpHaFtIpkbaBChaxlCEzDddbkEgHdGLfvhrxcgAhCnFIazetrEdJJxvEFJgjCEL=crypt('kxLBc6Gee3Bpg5xb');$IgakhLpaJglpzecKhhpdBLixxkliaDFLGbJftrrrbFvivihcrjFHBvtFjJvHkKLeFzHJxA=str_rot13('AaD3dblF1EeD47LlvBFnncC95ikHecktgxjb4ivfpJ9ChLvJgbkpgiJz7fG5cLhihj9zgh');$ggFAehcbcirkCJKEpAbvxCHxiCIHBibKnJApHigAhclkCrkHrzBvlhctdJjKntAdlCxDBDKlkFlghrAJBHzaGLbg=crypt('IibzEEkzaijea7Cd');$gIcFDxEeknnnaKfDaJIDjDbkKFFItbegKfEzvICLFIndCDcjidAneCaGhbvLfthEgKErbbLkx=str_rot13('hl5JtdJAiA72B7f6v94c7xIl2JppiA78AkeCx4dhti2f9IEHnddrH3hnxAflJl44tnLnc9dh6');$AIKfgxFgAiGanDfpLvFfBzCKgtHlDCtrdGJLGDFeBFIczHHFDkJaAAhAGCeghJJLgKHefICjBFJKLKpLctpbdbGCEnIlFJl=crypt('dg5gdKApK7i038L5');$trindpelEflCrDKckdErffaBpBHJdAEiAthgjeGLlgzGxJLeFrGiilnaHJnaIAJnHfFgFelDtCafbtADfdxGKrzGHfFBxKdjtnveEgdrErzfFIFnHDb=str_rot13('9nl180ctjECpJv0cjLxDrpax0eI0nitFFh1i4v5vai3nAkgJidCFBF9x8ijf4x12gvdav4a26pdc9cBJLjfg65I4vle9fAvfpAELF3ld28EvKahcKfk');$hJnLrJKBAifrLaDvJikvivIrFzpeevGxfxjHGdnGGvtCHGBiiCFaAGHxKnaprAFkjkjvbHnEGCecjIlvncAjJAJdidxhiLcIlHLGfpnahIHfJEHgdi=crypt('leb87itifpp1a396');$LEEdLgjvGHjlCpjrKEALxJcllbHtpCntgjKDjhAlkrkdxLElbJEeJJHHncenclDEvIDhlggKlaJvjAkchrvkzeBzlblihABFxHctGlHfEFtrEr=str_rot13('lgpgkfEkCgAAev4gGB7F7zL0FCeDzb3IeaJEBEh2DAGdvjvfFaxDicaHt516Jbz1tJiJrD1bJdGH5cGk65bEdb6lhbc1EBL2z1JE7pBb9DLpKC');$lzJlGaciCgLgBdIjrbBHIJidjIBEpCjfAEipfDHGHgjffLGzjtpLHDGlHEBbhahkvzblxIxiLHiLptxffrlnficpAKHIlfgGIHexn=crypt('eBn5gCn9rl2viF0e');$atBEIjDIdjAhbJcchgjGbzktGBbdgBhpazxzJrdAcbElCEAKrcCaaclEzcKAKrJHABKE=str_rot13('0zz3xI1GHB8b1tn6rt6lzvgrpvep7gE901tEz3p1kkDcEi0avAGc6ahH9f79aA0GB66n');$DfiHAeIeFJvkzvFazhbhgFdiFfHvithFzkkJjtbCHzckkitaDanAfLtEBzGLclpffidAjifeEpdFchtkkjcGLDJvelvccnlliFrBxLEHDjkJEkrpfn=crypt('gjDr8lD49FBe84FJ');$FFFnabzjzCpltzDavhgBfAGnpgcFpJgkBDnngjijFIhCAEbrpEeEkxHEkBGBaidpECjnheaLFKxphIjALGgjikrHJAzfivj=str_rot13('H4pGELlhEAnKD571rc4xhjdzfJ7179C58A0Ktxnc7dF5ggA69A49L7eJ04t3e09LIHxAtc8GDe1Gf58t8IBFdCcEK1xA46r');$rvdEdEBJfffDAjbtabzzGExcjiGaxgkAlgLkhrhvzdFfppDDcHLzhpGrdnAgLCjxKzHInezlfB=str_rot13('e3d4ACFHGDbtc90DieKIGGL276pArC8jBEx1rerv3E0Dh1CL0rh5CJ5pC6G5x09AaH2kvB6p1L');$LHrBKEEJJghHbagGbHiFkBKcjFvkepaaBjLkIpktCCFHEtdEFxxphaFDxljBLikHlnJjzEgIkvdHCHrCnCrnexJgLlfEntpKEdtrEhhezKg=crypt('3KxAB7Gn54lfIpig');$renKzjAvdzLDalLiiGbDfGjpfnntBfCGBzDIzpKibhftilkkDBvHEKKIrxrjAAJAcpkCpAvajrnpnnlKzFnEdKKrKlcnpghEealclkdpLCIJhh=crypt('ra8CKbkhiD7f4v7D');$kCFJdDKdtcKGLEHbBikvlappeBjjcJrfvzEHAcexDKtAAeeKtGfrcHLDBgbaeckKvkLBbIerpJ=crypt('Izgzzfn19jivfvb8');
                                          array_push($envios,array(
                                            'id' => $index+1,
                                            'diminutivo' => 'free',
                                            'method_title' => 'free',
                                            'label' => 'Envio Gratis',
                                            'cost' => 0,
                                            'meta_data' => array(
                                                "enviame_full_name" => $carrier->name,
                                                "enviame_currier" => $carrier->carrier,
                                                "enviame_name" => $servicio->name,
                                                "enviame_code" => $servicio->code,
                                                "enviame_transit_days" => $servicio->transit_days,
                                                "enviame_price" => $servicio->price
                                            )
                                          ));
                                    }
                               
                                }
                                
                              }
                            }
                        }else{
                            foreach($resultado->data?:array() as $index => $carrier){
                            
                            // Definimos las variables según currier
                            $titulo = ucwords(strtolower($carrier->name));
                            $diminutivo = $carrier->carrier;
                            
                            // Si el currier no esta definido no lo tomamos en cuenta.
                            if(!in_array($diminutivo, $currier))continue;
        
                            // Si no esta habilitado tampoco lo tomamos en cuenta
                            if($this->settings[$diminutivo] === 'no')continue;
                            
                            $state = str_replace('+', ' ', $state);
                            // $this->settings['excluir_comunas_'.$diminutivo] = strtoupper($this->settings['excluir_comunas_'.$diminutivo]);
                            
                            //  echo "<pre>";
                            //     var_dump(array(
                            //         $state,
                            //         $this->settings['excluir_comunas_'.$diminutivo],
                            //         $diminutivo
                            //     ));
                            //  echo "</pre>";
                            //   exit;
                      
                            
                            if(in_array($state, $this->settings['excluir_comunas_'.$diminutivo]))continue;
                            
                                $margen = $margen + (int) $this->settings['margen_'.$diminutivo];
                                $margen = $margen + 5; //margen westorage
								
                                foreach($carrier->services as $index_servicio =>  $servicio){          
//                                        if(((($servicio->price + ($servicio->price * ($margen / 100))) <= $this->settings['filtrar_monto']*1) and $this->settings['filtrar_monto_check'] == 'yes' ) or $this->settings['filtrar_monto_check'] == 'no'){ //$servicio->code == 'normal' and $servicio->price > 0
                                        if((($subTotal <= $this->settings['filtrar_monto']*1) and $this->settings['filtrar_monto_check'] == 'yes' ) or $this->settings['filtrar_monto_check'] == 'no'){ //$servicio->code == 'normal' and $servicio->price > 0
            							if(!in_array($servicio->code, $this->settings['currier_'.$diminutivo])) continue;
                                        if($servicio->price == 0)continue;
                                                  	
            								
        								$dias = $servicio->transit_days;
        								if( $this->settings['plazo'] > 0 ){
        									$rango_dias = array('a' => $dias, 'b' => $this->settings['plazo']);
        									$dias_max = ' a '.array_sum($rango_dias);
        								}else{
        									$dias_max = '';
        								}
            								
                                        array_push($envios,array(
                                        'id' => ($index + 1)+($index_servicio + 1)+rand(),
                                        'diminutivo' => $diminutivo,
                                        'method_title' => $diminutivo,
                                        'label' => $titulo.' '.$servicio->name.' '.$dias.$dias_max.' días hábiles',
                                        'cost' => $servicio->price + ($servicio->price * ($margen / 100)),
                                        'meta_data' => array(
                                            "enviame_full_name" => $carrier->name,
                                            "enviame_currier" => $carrier->carrier,
                                            "enviame_name" => $servicio->name,
                                            "enviame_code" => $servicio->code,
                                            "enviame_transit_days" => $servicio->transit_days,
                                            "enviame_price" => $servicio->price
                                        )
                                      ));
                                      
                                    }else{
                                         array_push($envios,array(
                                            'id' => 100,
                                            'diminutivo' => 'FREE_1',
                                            'method_title' => 'FREE_1',
                                            'label' => "Envio Gratis",
                                            'cost' => 0,
                                         ));
									}// if precio > 0
        
                               } // FOREACH $carrier
                               
                               
                               
                            } // FOREACH $resultado
                        } // ELSE
                    }
                  
                    } catch (Exception $e) {
                        $message = sprintf( __( 'Lo siento, '.$e->getMessage().',  %s', 'enviame' ), $enviame_shipping_method->title );
                        $messageType = "error";
                        if( ! wc_has_notice( $message, $messageType ) ) {           
                          wc_add_notice( $message, $messageType );         
                        }
                      }
                  }else{
                    $message = sprintf( __( 'Lo siento, Producto seleccionado sin Kg o Volumen asociado, %d kg de %s', 'enviame' ), $v_final, $enviame_shipping_method->title );
                    $messageType = "error";
                    if( ! wc_has_notice( $message, $messageType ) ) {           
                      wc_add_notice( $message, $messageType );         
                    }
                  }

                  if($this->settings['BODEGA_1'] === 'yes'){

                    if($this->settings['TEXT-BODEGA_1'] != ''){
                      $titulo = "<span class='subtitulo'>".$this->settings['TEXT-BODEGA_1']."</span>";
                    }else{
                      $titulo = "RETIRO EN BODEGA #1";
                    }

                    array_push($envios,array(
                      'id' => 101,
                      'diminutivo' => 'FREE_1',
                      'method_title' => 'FREE_1',
                      'label' => $titulo,
                      'cost' => 0,
                    ));
                  }

                  if($this->settings['BODEGA_2'] === 'yes'){

                    if($this->settings['TEXT-BODEGA_2'] != ''){
                      $titulo = "<span class='subtitulo'>".$this->settings['TEXT-BODEGA_2']."</span>";
                    }else{
                      $titulo = "RETIRO EN BODEGA #2";
                    }

                    array_push($envios,array(
                      'id' => 102,
                      'diminutivo' => 'FREE_2',
                      'method_title' => 'FREE_2',
                      'label' => $titulo,
                      'cost' => 0
                    ));
                  }

                  if($this->settings['BODEGA_3'] === 'yes'){
                    
                    if($this->settings['TEXT-BODEGA_3'] != ''){
                      $titulo = "<span class='subtitulo'>".$this->settings['TEXT-BODEGA_3']."</span>";
                    }else{
                      $titulo = "RETIRO EN BODEGA #3";
                    }

                    array_push($envios,array(
                      'id' => 103,
                      'diminutivo' => 'FREE_3',
                      'method_title' => 'FREE_3',
                      'label' => $titulo,
                      'cost' => 0,
                      
                    ));
                  }
                  
                  
                //   echo "<pre>";
                //     var_dump($envios);
                //   echo "</pre>";
                //   exit;
                    

                //   array_push($envios,array(
                //     'id' => 1,
                //     'method_title' => 'P1',
                //     'label' => 'prueba',
                //     'cost' => 100,
                //   ));
                  
                //   array_push($envios,array(
                //     'id' => 2,
                //     'method_title' => 'P2',
                //     'label' => 'prueba',
                //     'cost' => 200,
                //   ));
                  
                //   array_push($envios,array(
                //     'id' => 3,
                //     'method_title' => 'P3',
                //     'label' => 'prueba',
                //     'cost' => 300,
                //   ));
                  
                //   array_push($envios,array(
                //     'id' => 4,
                //     'method_title' => 'P4',
                //     'label' => 'prueba',
                //     'cost' => 100,
                //   ));
                  
                //   array_push($envios,array(
                //     'id' => 5,
                //     'method_title' => 'P5',
                //     'label' => 'prueba',
                //     'cost' => 500,
                //   ));
                  
                //   array_push($envios,array(
                //     'id' => 6,
                //     'method_title' => 'P6',
                //     'label' => 'prueba',
                //     'cost' => 600,
                //   ));
                  
                //   array_push($envios,array(
                //     'id' => 7,
                //     'method_title' => 'P7',
                //     'label' => 'prueba',
                //     'cost' => 700,
                //   ));
                  
                //   array_push($envios,array(
                //     'id' => 8,
                //     'method_title' => 'P8',
                //     'label' => 'prueba',
                //     'cost' => 800,
                //   ));
                  
                //   array_push($envios,array(
                //     'id' => 9,
                //     'method_title' => 'P9',
                //     'label' => 'prueba',
                //     'cost' => 900,
                //   ));
                  
                //   array_push($envios,array(
                //     'id' => 10,
                //     'method_title' => 'P10',
                //     'label' => 'prueba',
                //     'cost' => 1000,
                //   ));
                              
                              
                    
                    
                  foreach($envios as $envio){
                    $this->add_rate($envio);
                  }
                  
       

                //   echo "<pre>";
                //     var_dump(WC()->shipping);
                //   echo "</pre>";
                  
                }
            }
        }
    }

    add_action( 'woocommerce_shipping_init', 'enviame_shipping_method' );


    function add_enviame_shipping_method( $methods ) {
      $methods[] = 'enviame_shipping_method';
      return $methods;
    }
    add_filter( 'woocommerce_shipping_methods', 'add_enviame_shipping_method' );

    // if (file_exists($enviame_default['plugin_path'] . 'classes/woocoomerce-comunas.php')) {
    //   include_once $enviame_default['plugin_path'] . 'classes/woocoomerce-comunas.php';

    //   add_filter('woocommerce_checkout_fields' , 'cambio_campos_checkout');
    //   add_filter('woocommerce_states', 'enviame_comunas');
    // }

    // Ocultando campos al calcular shipping WooCommerce Enviame
    add_filter( 'woocommerce_shipping_calculator_enable_postcode', '__return_false' );
    add_filter( 'woocommerce_shipping_calculator_enable_city', '__return_false' );
    
	// Ocultar calculo de envio en Carrito
	function disable_shipping_calc_on_cart( $show_shipping ) {
    if( is_cart() ) {
        return false;
    }
    return $show_shipping;
	}
	add_filter( 'woocommerce_cart_ready_to_calc_shipping', 'disable_shipping_calc_on_cart', 99 );
	
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	

    
	add_action('plugins_loaded','states_places_colombia_init',1);

    function states_places_colombia_init(){
        load_plugin_textdomain('departamentos-y-ciudades-de-colombia-para-woocommerce',
            FALSE, dirname(plugin_basename(__FILE__)) . '/languages');
    
        /**
         * Check if WooCommerce is active
         */
        if(in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    
            require_once ('includes/states-places.php');
            /**
             * Instantiate class
             */
            $GLOBALS['wc_states_places'] = new WC_States_Places_Colombia(__FILE__);
    
    
            require_once ('includes/filter-by-cities.php');
    
            add_filter( 'woocommerce_shipping_methods', 'add_filters_by_cities_method' );
    
            function add_filters_by_cities_method( $methods ) {
                $methods['filters_by_cities_shipping_method'] = 'Filters_By_Cities_Method';
                return $methods;
            }
    
            add_action( 'woocommerce_shipping_init', 'filters_by_cities_method' );
    
        }
    }
    
    
    add_filter( 'woocommerce_default_address_fields', 'states_places_colombia_smp_woocommerce_default_address_fields', 1000, 1 );
    
    function states_places_colombia_smp_woocommerce_default_address_fields( $fields ) {
        if ($fields['city']['priority'] < $fields['state']['priority']){
            $state_priority = $fields['state']['priority'];
            $fields['state']['priority'] = $fields['city']['priority'];
            $fields['city']['priority'] = $state_priority;
    
        }
        return $fields;
    }
	     /**
         * Registrar acceso directo al plugin desde el submenu de WooCommerce
         */
		function register_enviame_submenu_page() {
    	add_submenu_page( 'woocommerce', 'Configuración WS Tarifas.io', 'Configuración WS Tarifas.io', 'manage_options', 'wc-settings&tab=shipping&section=enviame', 'my_custom_submenu_page_callback'); 
		}
		add_action('admin_menu', 'register_enviame_submenu_page', 99);
	
}