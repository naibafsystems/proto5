<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para el modulo de ejecutable
 * Modificado para ecenso version 2017
 * @author hhchavezv - oagarzond
 * @since 2017oct10
 */
class Ejecutable extends MX_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->model("my_model");
		$this->data= array();
        $this->module = $this->uri->segment(1);
        $this->data['msgError'] = $this->data['msgSuccess'] = $this->data['msgWelcome'] = '';
        $this->data["module"] = (!empty($this->module)) ? $this->module: 'login';
        $this->data['navbarLeftSide'] = 'navbarLeftSide';
		$this->data['footer'] = 'footer';
		$this->data['arrJS'][] = base_url_js('ejecutable/ejecutable.js');
		$this->data['arrCss'][] = base_url_plugins('jquery.qtip/jquery.qtip.min.css');
        $this->data['arrJS'][] = base_url_plugins('moment/js/moment.min.js');
        $this->data['arrJS'][] = base_url_plugins('jquery.qtip/jquery.qtip.js');
        $this->data['arrJS'][] = base_url_js('fillInFormTimer.js');
    }

	public function inicio_old22() {
		$this->data['title'] = 'eCenso Offline';
        $this->data['classContainer'] = 'container';
        $this->data['msgSuccess'] = $this->data['msgError'] = '';
        $this->data['URLejecutable'] = base_url_files('eCenso_setup.exe');
		$this->data['view'] = 'ejecutable';
		$this->load->view('layout', $this->data);
	}

    public function index() {
        $this->data['msgSuccess'] = $this->data['msgError'] = '';
        $this->data['URLejecutable'] = base_url_files('eCenso_setup.exe');
        $this->data['URLcomprimido'] = base_url_files('eCenso_compressed.exe');
        $subeArchivo = false;
        $arrError = array();
        $datosUsu=$this->input->post();
		$filess = $_FILES;
		$arr_cod_encuestas=array();
		
		try{
			if(!empty($datosUsu) && count($datosUsu) > 0 ){
				// Guarda información de quien carga
				$idcargue= $this->my_model->obtener_siguiente_id('SEQ_ECP_CARGUE_OFF');
				$cargue_uno=$idcargue;
				$cont_cargue=0;
				$arrUsu["ID_CARGUE"]=$idcargue;// PK
				$arrUsu["TIPO_DOC"]=$datosUsu["tipo_documento"];
				( !is_null($datosUsu["tipo_documento2"]) && $datosUsu["tipo_documento2"] != ''  )?$arrUsu["TIPO_DOC2"]=$datosUsu["tipo_documento2"]:'';
				( !is_null($datosUsu["numero_documento"]) && $datosUsu["numero_documento"] != ''  )?$arrUsu["NRO_DOC"]=$datosUsu["numero_documento"]:'';
				$arrUsu["NOMBRE1"]=$datosUsu["primer_nombre"];
				( !is_null($datosUsu["segundo_nombre"]) && $datosUsu["segundo_nombre"] != ''  )?$arrUsu["NOMBRE2"]=$datosUsu["segundo_nombre"]:'';
				$arrUsu["APELLIDO1"]=$datosUsu["primer_apellido"];
				( !is_null($datosUsu["segundo_apellido"]) && $datosUsu["segundo_apellido"] != ''  )?$arrUsu["APELLIDO2"]=$datosUsu["segundo_apellido"]:'';
				( !is_null($datosUsu["telefono_celular"]) && $datosUsu["telefono_celular"] != ''  )?$arrUsu["TEL_CELULAR"]=$datosUsu["telefono_celular"]:'';
				( !is_null($datosUsu["correo_electronico"]) && $datosUsu["correo_electronico"] != ''  )?$arrUsu["EMAIL"]=$datosUsu["correo_electronico"]:'';
				$arrUsu["FECHA_HORA_CARGUE"]=$this->my_model->consultar_fecha_hora();
				if (!$this->my_model->ejecutar_insert('WCP_CARGUE_OFF', $arrUsu) ) {
					$this->data['msgError']  ="No se puede guardar la información de la persona que hace el cargue.";
					throw new RuntimeException($this->data['msgError']); 
				}
			}
			if (!empty($filess) && count($filess) > 0) {
	            //valido tamaño
				if ($_FILES['cargaArchivo']['size'] > 3000000) {//3Mb
					$this->data['msgError']  ="El archivo ".$_FILES['cargaArchivo']['name']." excede el tamano permitido.";
					throw new RuntimeException($this->data['msgError']);
				} else {
					$subeArchivo = true;
					//$config['upload_path'] = $this->data['base_dir'] = substr(base_dir(), 0, -1) . '\files\\'; // Ruta servidor web local
					$config['upload_path'] = $this->data['base_dir'] = base_dir('files/tmp/'); // Ruta servidor web con IP
					$config['overwrite'] = true;
					// Como originalmente no deja subir json se debe agregar el json en application/config/mimes.php
					$config['allowed_types'] = 'zip|csv';
					$config['max_size'] = '256';
					$config['file_ext_tolower'] = TRUE;
					//pr($config);
					//$config['encrypt_name'] = TRUE;
					//$config['file_name'] = 'nombre';
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('cargaArchivo')) {
						$error = $this->upload->display_errors();
						$this->data['msgError'] = html_escape(substr($error, 3, -4));
						throw new RuntimeException($this->data['msgError']);
					} else {
						$this->data['fileInfo'] = $this->upload->data();
						$this->data['msgSuccess'] = 'Se subió correctamente el archivo con el nombre ' . $this->data['fileInfo']['file_name'] . '.';
					}
				}	
	        }
	        if ($subeArchivo && empty($this->data['msgError'])) {
              $numeForm = $this->my_model->obtener_siguiente_id('SEQ_WCP_ENCUESTAS');
              copy(FCPATH . 'files/tmp/' . $this->data['fileInfo']['file_name'], FCPATH . 'files/tmp/' . $numeForm . $this->data['fileInfo']['file_ext']);
	            $zip = new ZipArchive;
	            if (strtolower($this->data['fileInfo']['file_ext']) == '.zip') {
					if ($zip->open($config['upload_path'] . $this->data['fileInfo']['file_name']) === TRUE) {
	                    $zip->extractTo($config['upload_path']);
	                    $zip->close();
	                    // Suponemos que el archivo dentro tiene el mismo nombre que el archivo .zip
	                    $dataExtra = file_get_contents($config['upload_path'] . $this->data['fileInfo']['raw_name']);
	                    if($dataExtra == FALSE) {
	                        $this->data['msgError'] = 'No se pudo leer el contenido del archivo ' . $this->data['fileInfo']['file_name'] . '.';
							throw new RuntimeException($this->data['msgError']);
	                    } else {
	                        $dataJson = base64_decode(substr($dataExtra, 5, -5));
	                        $arrEncuestas = json_decode($dataJson, true);
	                        if($arrEncuestas == FALSE) {
	                            $this->data['msgError'] = 'No está correctamente costruido el contenido del archivo ' . $this->data['fileInfo']['file_name'] . '.';
								throw new RuntimeException($this->data['msgError']);
	                        }
	                    }
	                } else {
	                    $this->data['msgError'] = 'No se puedo abrir el archivo ' . $this->data['fileInfo']['file_name'] . '.';
						throw new RuntimeException($this->data['msgError']);
	                }
	            } else {
	                $this->data['msgError'] = 'El archivo ' . $this->data['fileInfo']['file_name'] . ' no es un archivo con extensión zip.';
					throw new RuntimeException($this->data['msgError']);
	            }
	        }
	        if ($subeArchivo && empty($this->data['msgError']) && !empty($arrEncuestas) && count($arrEncuestas) > 0) {
	            $this->load->model('personas/modpersonas', 'mpers');
				foreach ($arrEncuestas as $ke => $ve) {
	                if (!empty($ve) && count($ve) > 0) {
						// Se valida si alguno de los integrantes ya existe en la BD
						if(isset($ve["persHogar"])) { // no trae tabla persHogar, para casos de formulario "no acepto",
							foreach ( $ve["persHogar"] as $vpho) {
								$arrPers = $this->mpers->consultarPersonas(array('tipoDocu' => $vpho['PA_TIPO_DOC'], 'numeDocu' => $vpho['PA1_NRO_DOC']));
								if(count($arrPers) > 0) {
									$msj_tmp='- No se puede guardar la información de ' . $vpho['PA_1ER_NOMBRE'] . ' ' . $vpho['PB_1ER_APELLIDO'] . ' con número de identificación '.$vpho['PA1_NRO_DOC'].', pues ya existe en el eCenso.';
									$arrError[] = $msj_tmp;
								}
							}
						}
					} else {
						$arrError[] = 'No se encontró información para el formulario ' . $ke . '.';
					}
				}
			}	
			//$i=0;//pruebas unitarias
			/*VALIDACION OK - COLOCAR *********/
	        if (!empty($arrError) && count($arrError)) {
	            $this->data['msgError'] = implode('<br />', $arrError);
				$this->data['msgSuccess']="";
				throw new RuntimeException( $this->data['msgError']);
	            unset($arrError);
	        } else if ($subeArchivo && empty ($this->data['msgError'])) {
			//@todo: se debe reemplazar los campos con nro encuesta al que lleva en la BD
	        // Se valida que los campos no tenga nulos o vacios
				foreach ($arrEncuestas as $ke => $ve) { // Recorre cada formulario, en caso de haber varios.
					$idUsuario = $this->my_model->obtener_siguiente_id('SEQ_WCP_ADMIN_USUARIOS');
					$arr_cod_encuestas[]=$numeForm;
					//$idSolicitud = $this->my_model->obtener_siguiente_id('SEQ_ECP_FORM_SOLICITUD');
					$idHogar = $this->my_model->obtener_siguiente_id('SEQ_WCP_HOGAR');
					$idVivienda = $this->my_model->obtener_siguiente_id('SEQ_WCP_VIVIENDA');
					// Vars de sesion para descarga de formulario
					$this->session->set_userdata('codiEncuesta', $numeForm);
					$this->session->set_userdata('codiVivienda', $idVivienda);
					$this->session->set_userdata('codiHogar', $idHogar);
					foreach ($ve as $ke1 => $ve1) {
	                    if (is_array($ve1) && count($ve1) > 0) {
	                      	foreach ($ve1 as $ke2 => $ve2) {
	                             if (is_array($ve2) && count($ve2) > 0) {
	                                foreach ($ve2 as $ke3 => $ve3) {
	                                    if (is_null($ve3) || $ve3 == '') {
	                                        unset($ve[$ke1][$ke2][$ke3]);
	                                        continue;
	                                    }
	                                    if (es_fecha_valida_mysql($ve3)) { 
	                                        $ve[$ke1][$ke2][$ke3] = formatear_fecha_mysql($ve3);
	                                    }
	                                    if (es_fecha_hora_valida_mysql($ve3)) {
	                                        $ve[$ke1][$ke2][$ke3] = formatear_fecha_hora_mysql($ve3);
	                                    }
	                                    // Asignacion de IDs
										if (in_array($ke3, array('ID_USUARIO'))) {
	                                        $ve[$ke1][$ke2][$ke3] = $idUsuario;
	                                    }
										if (in_array($ke3, array('USUARIO_INSERCION','USUARIO_MODIFICACION'))) {
	                                        $ve[$ke1][$ke2][$ke3] = $idUsuario;
	                                    }
										if (in_array($ke3, array('COD_ENCUESTAS'))) {
	                                        $cod_orig=$ve[$ke1][$ke2][$ke3];
											$ve[$ke1][$ke2][$ke3] = $numeForm;
	                                    }
										if (in_array($ke3, array('ID_HOGAR'))) {
	                                        $ve[$ke1][$ke2][$ke3] = $idHogar;
	                                    }
										if (in_array($ke3, array('ID_VIVIENDA'))) {
	                                        $ve[$ke1][$ke2][$ke3] = $idVivienda;
	                                    }
	                                }
	                            } else {
	                                // Asignacion de IDs
									if (in_array($ke2, array('ID_USUARIO'))) {
                                        $ve[$ke1][$ke2] = $idUsuario;
                                    }
									if (in_array($ke2, array('USUARIO_INSERCION','USUARIO_MODIFICACION'))) {
                                        $ve[$ke1][$ke2] = $idUsuario;
                                    }
									if (in_array($ke2, array('COD_ENCUESTAS'))) {
                                        $ve[$ke1][$ke2] = $numeForm;
                                    }
									if (in_array($ke2, array('	ID_SOLICITUD'))) {
                                        $ve[$ke1][$ke2] = $idSolicitud;
                                    }
									if (in_array($ke2, array('ID_HOGAR'))) {
                                        $ve[$ke1][$ke2] = $idHogar;
                                    }
									if (in_array($ke2, array('ID_VIVIENDA'))) {
                                        $ve[$ke1][$ke2] = $idVivienda;
                                    }
	                            }
	                            if (is_null($ve2) || $ve2 == '') {
	                                unset($ve[$ke1][$ke2]);
	                                continue;
	                            }
	                            if (!empty($ve2) && es_fecha_valida_mysql($ve2)) {
	                                $ve[$ke1][$ke2] = formatear_fecha_mysql($ve2);
	                            }
								if (es_fecha_hora_valida_mysql($ve2)) {
									$ve[$ke1][$ke2] = formatear_fecha_hora_mysql($ve2);
								}	
	                        }							 
	                    }
	                }
					if (!empty($ve['encuestas']) && count($ve['encuestas']) > 0) {
	                	if (!$this->my_model->ejecutar_insert('WCP_ENCUESTAS', $ve['encuestas'])) {
							throw new RuntimeException( 'No se puede guardar la información en la tabla ENCUESTAS del formulario ' . $ke . '.');
						}
	                } else {
	                    $arrError[] = 'No se encontró información de encuestas del formulario ' . $ke . '.';
	                }
					// Guarda datos de quien carga
					if($cont_cargue ==0){ // Primer registro ya se creo al incio
						$cont_cargue ++;
						// Adiciona COD_ENCUESTAS para relacionar a la persona q carga
						$arrVal=$arrUpd=array();
						$arrVal["COD_ENCUESTAS"]=$numeForm;
						$arrUpd["ID_CARGUE"]=$idcargue;
						if ( !$this->my_model->ejecutar_update('WCP_CARGUE_OFF', $arrVal, $arrUpd) ){
						   throw new RuntimeException('No se puede actualizar la información de la persona que hace el cargue.'); 
						}
					} else {
						$idcargue= $this->my_model->obtener_siguiente_id('SEQ_ECP_CARGUE_OFF');
						$arrUsu["ID_CARGUE"]=$idcargue;// PK
						$arrUsu["COD_ENCUESTAS"]=$numeForm;
						$arrUsu["FECHA_HORA_CARGUE"]=$this->my_model->consultar_fecha_hora();
						if (!$this->my_model->ejecutar_insert('WCP_CARGUE_OFF', $arrUsu)) {
						   throw new RuntimeException('No se puede guardar la información de la persona que hace el cargue.');
						}
					}
					if (!empty($ve['vivienda']) && count($ve['vivienda']) > 0) {
	                    if (!$this->my_model->ejecutar_insert('WCP_VIVIENDA', $ve['vivienda'])) {
	                        throw new RuntimeException('No se puede guardar la información en la tabla VIVIENDA del formulario' . $ke . '.');
	                    }
	                } else {
	                    $arrError[] = 'No se encontró información de vivienda del formulario' . $ke . '.';
	                }
	                if (!empty($ve['hogar']) && count($ve['hogar']) > 0) {
	                    if (!$this->my_model->ejecutar_insert('WCP_HOGAR', $ve['hogar'])) {
	                        throw new RuntimeException( 'No se puede guardar la información en la tabla HOGAR del formulario' . $ke . '.');
	                    }
	                } else {
	                    $arrError[] = 'No se encontró información de hogar del formulario' . $ke . '.';
	                }
	                if (!empty($ve['persResi']) && count($ve['persResi']) > 0) {
	                    foreach ($ve['persResi'] as $kpp => $vpp) {
							//hch - incluir secuencia, PERO TAMBIEN  en las otras tablas por FK
							$idPersResid = $this->my_model->obtener_siguiente_id('SEQ_WCP_PERSONAS_RESIDENTES');
							if($vpp['RA1_NRO_RESI'] == 1) {//jefe de hogar
								$this->session->set_userdata('idPers',$idPersResid);
							}
							if( isset($ve['usuarios']['ID_PERSONA_RESIDENTE'])) {
								if( $vpp['ID_PERSONA_RESIDENTE'] == $ve['usuarios']['ID_PERSONA_RESIDENTE']) {
									$ve['usuarios']['ID_PERSONA_RESIDENTE']=$idPersResid;
									//$arrEncuestas[$ke]['usuarios']['ID_PERSONA_RESIDENTE']=$idPersResid;
								}
							}	
							// asigna id a tabla ecp_admin_control_personas
							foreach ($ve['controlPers'] as $k => $reg) {
								if( $vpp['ID_PERSONA_RESIDENTE'] == $reg['ID_PERSONA_RESIDENTE']) {
									$ve['controlPers'][$k]['ID_PERSONA_RESIDENTE']=$idPersResid;
									//$arrEncuestas[$ke]['controlPers'][$kpp]['ID_PERSONA_RESIDENTE']=$idPersResid;
								}
							}
							// asigna id a tabla ECP_PERSONAS_HOGAR
							foreach ($ve['persHogar'] as $k => $reg) {
								if( $vpp['ID_PERSONA_RESIDENTE'] == $reg['ID_PERSONA_HOGAR']) {
									$ve['persHogar'][$k]['ID_PERSONA_HOGAR']=$idPersResid;
									//$arrEncuestas[$ke]['persHogar'][$kpp]['ID_PERSONA_HOGAR']=$idPersResid;
								}
							}
							// PROBAR Y CONTINUAR CON LAS OTRAS TABLAS DEPENDIENTES
							$ve['persResi'][$kpp]['ID_PERSONA_RESIDENTE']=$idPersResid;
				    		if (!$this->my_model->ejecutar_insert('WCP_PERSONAS_RESIDENTES', $ve['persResi'][$kpp])) {
	                        	throw new RuntimeException( 'No se puede guardar la información en la tabla PERSONAS_RESIDENTES del formulario' . $ke . '.');
	                        }
						}
	                } else {
	                    $arrError[] = 'No se encontró información de personas_residentes del formulario ' . $ke . '.';
	                }
					if (!empty($ve['usuarios']) && count($ve['usuarios']) > 0) {
	                    if (!$this->my_model->ejecutar_insert('WCP_ADMIN_USUARIOS', $ve['usuarios'])) {
	                        throw new RuntimeException( 'No se puede guardar la información en la tabla USUARIOS del formulario' . $ke . '.');
	                    }
	                } else {
	                    $arrError[] = 'No se encontró información de usuarios del formulario' . $ke . '.';
	                }
					if (!empty($ve['control']) && count($ve['control']) > 0) {
	                   if (!$this->my_model->ejecutar_insert('WCP_ADMIN_CONTROL', $ve['control'])) {
							throw new RuntimeException( 'No se puede guardar la información en la tabla CONTROL del formulario ' . $ke . '.');
						}
	                } else {
	                    $arrError[] = 'No se encontró información de control del formulario ' . $ke . '.';
	                }
					if (!empty($ve['controlPers']) && count($ve['controlPers']) > 0) {
	                    foreach ($ve['controlPers'] as $kpp => $vpp) {
							if (!$this->my_model->ejecutar_insert('WCP_ADMIN_CONTROL_PERSONAS', $ve['controlPers'][$kpp])) {
								throw new RuntimeException('No se puede guardar la información en la tabla CONTROL_PERSONAS del formulario' . $ke . '.');
		                	}
	                    }
	                } else {
	                    $arrError[] = 'No se encontró información de controlPers del formulario ' . $ke . '.';
	                }
					if (!empty($ve['persHogar']) && count($ve['persHogar']) > 0) {
	                    foreach ($ve['persHogar'] as $kpp => $vpp) {
							if (!$this->my_model->ejecutar_insert('WCP_PERSONAS_HOGAR', $ve['persHogar'][$kpp])) {
	                        	throw new RuntimeException( 'No se puede guardar la información en la tabla PERSONAS_HOGAR del formulario' . $ke . '.');
	                        }
	                    }
	                } else {
	                    $arrError[] = 'No se encontró información de persHogar del formulario ' . $ke . '.';
	                }
					if (!empty($ve['persFalle']) && count($ve['persFalle']) > 0) {
	                    foreach ($ve['persFalle'] as $kpp => $vpp) {
							$idPersFallec = $this->my_model->obtener_siguiente_id('SEQ_WCP_PERSONAS_FALLECIDAS');
							$ve['persFalle'][$kpp]['ID_PERSONA_FALLECIDA']=$idPersFallec;
							if (!$this->my_model->ejecutar_insert('WCP_PERSONAS_FALLECIDAS', $ve['persFalle'][$kpp])) {
	                           throw new RuntimeException('No se puede guardar la información en la tabla PERSONAS_FALLECIDAS del formulario' . $ke . '.');
	                        }
	                    }
	                }
					if (!empty($ve['resEntrevista']) && count($ve['resEntrevista']) > 0) {
	                    foreach ($ve['resEntrevista'] as $kpp => $vpp) {
							$idResEntrev = $this->my_model->obtener_siguiente_id('SEQ_WCP_RESULTADOS_ENTREVISTA');
							// asigna id a tabla ecp_tiempos_entrevista
							foreach ($ve['timeEntrevista'] as $k => $reg) {
								if( $vpp['ID_RESULTADOS_ENTREVISTA'] == $reg['ID_RESULTADOS_ENTREVISTA'] )
								{
									$ve['timeEntrevista'][$k]['ID_RESULTADOS_ENTREVISTA']=$idResEntrev;
									//$arrEncuestas[$ke]['controlPers'][$kpp]['ID_PERSONA_RESIDENTE']=$idPersResid;
								}
							}
							$ve['resEntrevista'][$kpp]['ID_RESULTADOS_ENTREVISTA']=$idResEntrev;
						
							if (!$this->my_model->ejecutar_insert('WCP_RESULTADOS_ENTREVISTA', $ve['resEntrevista'][$kpp])) {
	                            throw new RuntimeException('No se puede guardar la información en la tabla RESULTADOS_ENTREVISTA del formulario' . $ke . '.');
	                        }
	        			}
	                } else {
	                    $arrError[] = 'No se encontró información de resEntrevista del formulario ' . $ke . '.';
	                }
					if (!empty($ve['timeEntrevista']) && count($ve['timeEntrevista']) > 0) {
	                    foreach ($ve['timeEntrevista'] as $kpp => $vpp) {
							if (!$this->my_model->ejecutar_insert('WCP_TIEMPOS_ENTREVISTA', $ve['timeEntrevista'][$kpp])) {
	                    		throw new RuntimeException( 'No se puede guardar la información en la tabla TIEMPOS_ENTREVISTA del formulario' . $ke . '.');
	                    	}
	                	}
	                } else {
	                    $arrError[] = 'No se encontró información de timeEntrevista del formulario ' . $ke . '.';
	                }
					if (!empty($ve['noAcepto']) && count($ve['noAcepto']) > 0) {
	                    foreach ($ve['noAcepto'] as $kpp => $vpp) {
							$idNoAcepto = $this->my_model->obtener_siguiente_id('SEQ_WCP_NO_ACEPTO');
							$ve['noAcepto'][$kpp]['ID_NO_ACEPTO']=$idNoAcepto;
							if (!$this->my_model->ejecutar_insert('WCP_NO_ACEPTO', $ve['noAcepto'][$kpp])) {
	                        	throw new RuntimeException(  'No se puede guardar la información en la tabla NO_ACEPTO del formulario ' . $ke . '.');
	                        }
	                 	}
	                }
					if (!empty($ve['formato_1']) && count($ve['formato_1']) > 0) {
	                	if (!$this->my_model->ejecutar_insert('WCP_FORMATO_1', $ve['formato_1'])) {
	                    	throw new RuntimeException( 'No se puede guardar la información en la tabla FORMATO_1 del formulario' . $ke . '.');
	                    }
	                } else {
	                    $arrError[] = 'No se encontró información de formato_1 del formulario' . $ke . '.';
	                }		
					// Actualiza campo CARGA_OK=1 de tabla registro de usuario q carga
					$arrVal=$arrUpd=array();
					$arrVal["CARGA_OK"]=1;
					$arrUpd["COD_ENCUESTAS"]=$numeForm;
					$this->my_model->ejecutar_update('WCP_CARGUE_OFF', $arrVal, $arrUpd);
	                if (!empty($arrError) && count($arrError)) {
	                    $this->data['msgError'] = implode('<br />', $arrError);
	                    throw new RuntimeException($this->data['msgError']);
						unset($arrError);
						
	                } else {
	                   $this->data['msgSuccess'] .= '<br /> Se subió correctamente la información del formulario '. $cod_orig. '.';
                     copy(FCPATH . 'files/tmp/' . $this->data['fileInfo']['raw_name'], FCPATH . 'files/tmp/' . $numeForm);
                     unlink(FCPATH . 'files/tmp/' . $this->data['fileInfo']['raw_name']);
                     unlink(FCPATH . 'files/tmp/' . $this->data['fileInfo']['file_name']);
	                }
				}
				// Finaliza
				if (empty($this->data['msgError'])) {
	                    $this->data['msgSuccess'] .= '<br /> !!! SE SUBIÓ CORRECTAMENTE TODA LA INFORMACIÓN DEL CARGUE !!!';
						$this->session->set_userdata('msj_ejecuta', '1');
						redirect("ejecutable/finEjecutable");
						exit;
					} else {
	                    throw new RuntimeException('ERROR: existen errores en el cargue.');
	                }
			
			}
			$this->data['title'] = 'eCenso Offline';
	        $this->data['classContainer'] = 'container';
	        $this->data['URLejecutable'] = base_url_files('eCenso_setup.exe');
			$this->data['view'] = 'ejecutable';
			$this->load->view('layout', $this->data);
		}

		catch (RuntimeException $e) {
			// Se borra toda la información guardada
			$this->load->model("modejecutable");
			if( count($arr_cod_encuestas)>0 ){
				foreach ($arr_cod_encuestas as $k => $cod) {
					$this->modejecutable->eliminaEncuesta($cod);// VERIFICADO
					// Actualiza campo CARGA_OK=2 de tabla registro de usuario q carga
					$arrVal=$arrUpd=array();
					$arrVal["CARGA_OK"]=2;
					$arrVal["OBSERVACION"]=$this->data['msgError'];
					$arrUpd["COD_ENCUESTAS"]=$cod;
					$this->my_model->ejecutar_update('WCP_CARGUE_OFF', $arrVal, $arrUpd);
				}
			} else {
				//VERFICAR SI YA EXISTE ESTE REGISTRO EN BD
				// Actualiza campo CARGA_OK=2 de tabla registro de usuario q carga
				$arrVal=$arrUpd=array();
				$arrVal["CARGA_OK"]=2;
				$arrVal["OBSERVACION"]=$this->data['msgError'];
				$arrUpd["ID_CARGUE"]=$cargue_uno;
				$this->my_model->ejecutar_update('WCP_CARGUE_OFF', $arrVal, $arrUpd);
			}
			$this->data['msgError'] .= '<br /><br /> !!! SURGIERON ERRORES  AL REALIZAR EL CARGUE !!! <br>Cierre la página y vuelva a ingresar, e intente nuevamente. Si continúa el error por favor tome nota del error que aparece y contáctese con los medios de atención al usuario.';
			$this->data['msgSuccess']= "";
			$this->data['title'] = 'eCenso Offline';
	        $this->data['classContainer'] = 'container';
	        $this->data['URLejecutable'] = base_url_files('eCenso_setup.exe');
			$this->data['view'] = 'ejecutable';
			$this->load->view('layout', $this->data);
		}
	}

	public function finEjecutable() {
		$msj_ejecuta=$this->session->userdata('msj_ejecuta');
		$this->data['mostrar_msgSuccess'] = 0;
		$this->data['title'] = 'eCenso Offline';
        $this->data['classContainer'] = 'container';
		if(isset($msj_ejecuta) && $msj_ejecuta==1  ){
			$this->data['msgSuccess'] = "!!! SUBIÓ LA INFORMACIÓN CORRECTAMENTE !!!";
			$this->data['mostrar_msgSuccess'] = 1;
		}
        $this->data['view'] = 'msj_ejecutable';
		$this->load->view('layout', $this->data);
	}

	/**
     * Genera el PDF de la constancia de diligenciamiento
     * @author aocubillosa
     * @since 2018-01-04
     */
    public function generarConstancia() {
        $this->load->model('modform', 'mform');
        $this->load->model('personas/modpersonas', 'mpers');
        $codiEncuesta = $this->data['codiEncuesta'] = $this->session->userdata('codiEncuesta');
        $fechaCertificado = date('d/m/Y');
        $this->data['view'] = 'constanciaHTML';
        $this->data['title'] = 'Constancia';
        $this->data['ecensoHeader'] = '<img src="' . base_url_images('certificateHeader.png') . '" />';
        //$this->data['ecensoHeader'] = '';
        $this->data['ecensoFooter'] = '<img src="' . base_url_images('certificateFooter.png') . '" />';
        //$this->data['ecensoFooter'] = '';
        $this->data['expedicion'] = obtener_texto_fecha(formatear_fecha($fechaCertificado));
        $arrParam = array(
            'codiEncuesta' => $codiEncuesta,
            'codiVivienda' => $this->session->userdata('codiVivienda'),
            'codiHogar' => $this->session->userdata('codiHogar'),
            'idPers' => $this->session->userdata('idPers')
        );
        $arrPersona = $this->mpers->consultarPersonas($arrParam);
        $arrParam = array(
            'codiEncuesta' => $codiEncuesta,
            'sidx' => 'PR.RA1_NRO_RESI',
            'sord' => 'ASC'
        );
        $arrPersResi = $this->mpers->consultarPersonas($arrParam);
        if(count($arrPersResi) > 0) {
            $arrTipoDocus = $this->mform->consultarRespuestaDominio(array('idDominio' => 26));
            foreach ($arrPersResi as $kpers => $vpers) {
                $arrPers[$vpers['ID_PERSONA_RESIDENTE']]['nombre'] = $vpers['nombre'];
                $arrPers[$vpers['ID_PERSONA_RESIDENTE']]['jefe'] = 'NO';
                $arrPers[$vpers['ID_PERSONA_RESIDENTE']]['numero_docu'] = $vpers['PA1_NRO_DOC'];
                if($vpers['RA1_NRO_RESI'] == 1) {  // Es el jefe(a) del hogar
                    $arrPers[$vpers['ID_PERSONA_RESIDENTE']]['jefe'] = 'SI';
                }
                if(!empty($arrUsua['ID_PERSONA_RESIDENTE']) && $vpers['ID_PERSONA_RESIDENTE'] == $arrUsua['ID_PERSONA_RESIDENTE']) {
                    $nombre = $vpers['nombre'];
                }
                foreach ($arrTipoDocus as $ktd => $vtd) {
                    if($vtd['ID_VALOR'] == $vpers['PA_TIPO_DOC']) {
                        $arrPers[$vpers['ID_PERSONA_RESIDENTE']]['tipo_docu'] = $vtd['DESCRIPCION'];
                    }
                }
            }
        }
        if(count($arrPers) > 0) {
            $this->data['listaPersonas'] = '<ul>';
            foreach ($arrPers as $kpers => $vpers) {
                $this->data['listaPersonas'] .= '<li><span style="font-weight:700;">' . $vpers['nombre'] . '</span> ' . $vpers['tipo_docu'] . '  <span>' . $vpers['numero_docu'] .  '</span>';
                if($vpers['jefe'] == 'SI') {
                    //$this->data['listaPersonas'] .= ' (Jefe(a) del hogar)';
                }

                if ($vpers !== end($arrPers)) {
                    $this->data['listaPersonas'] .= ',';
                }

                $this->data['listaPersonas'] .= '</li>';
            }
            $this->data['listaPersonas'] .= '</ul>';
        }
        //pr($this->data); exit;
        $html = $this->load->view($this->data['view'], $this->data, true);
        echo $html; exit;
    }

} //EOC