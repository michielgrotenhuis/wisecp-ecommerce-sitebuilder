<?php
    class SampleProduct extends ProductModule
    {
        function __construct(){
            $this->_name = __CLASS__;
            parent::__construct();
        }


        public function configuration()
        {
            $action             = isset($_GET["action"]) ? $_GET["action"] : false;
            $action             = Filter::letters_numbers($action);

            $vars = [
                'm_name'        => $this->_name,
                'area_link'     => $this->area_link,
                'lang'          => $this->lang,
                'config'        => $this->config,
            ];
            return $this->get_page("configuration".($action ? "-".$action : ''),$vars);
        }

        /*
         * Configuration with Form Elements -> Controller
        */
        public function controller_save()
        {
            $example1       = Filter::init("POST/example1","hclear");
            $example2       = Filter::init("POST/example2","password");
            $example3       = (int) Filter::init("POST/example3","numbers");

            $set_config     = $this->config;

            if($set_config["settings"]["example1"] != $example1) $set_config["settings"]["example1"] = $example1;
            if($set_config["settings"]["example2"] != $example2) $set_config["settings"]["example2"] = $example2;
            if($set_config["settings"]["example3"] != $example3) $set_config["settings"]["example3"] = $example3;

            if(Validation::isEmpty($example1))
            {
                echo Utility::jencode([
                    'status' => "error",
                    'message' => $this->lang["error1"],
                ]);
                return false;
            }

            $this->save_config($set_config);


            echo Utility::jencode([
                'status' => "successful",
                'message' => $this->lang["success1"],
            ]);

            return true;
        }

        public function config_options($data=[])
        {
            return [
                'example1'          => [
                    'name'              => "Text Box",
                    'description'       => "Text Box Description",
                    'type'              => "text",
                    'width'             => "50",
                    'value'             => isset($data["example1"]) ? $data["example1"] : "sample",
                    'placeholder'       => "sample placeholder",
                ],
                'example2'          => [
                    'name'              => "Password Box",
                    'description'       => "Password Box Description",
                    'type'              => "password",
                    'width'             => "50",
                    'value'             => isset($data["example2"]) ? $data["example2"] : "sample",
                    'placeholder'       => "sample placeholder",
                ],
                'example3'          => [
                    'name'              => "Approval Button",
                    'description'       => "Approval Button Description",
                    'type'              => "approval",
                    'checked'           => isset($data["example3"]) && $data["example3"] ? true : false,
                ],
                'example4'          => [
                    'name'              => "Dropdown Menu 1",
                    'description'       => "Dropdown Menu 1 Description",
                    'type'              => "dropdown",
                    'options'           => "Option 1,Option 2,Option 3,Option 4",
                    'value'             => isset($data["example4"]) ? $data["example4"] : "Option 2",
                ],
                'example5'          => [
                    'name'              => "Dropdown Menu 2",
                    'description'       => "Dropdown Menu 2 Description",
                    'type'              => "dropdown",
                    'options'           => [
                        'opt1'     => "Option 1",
                        'opt2'     => "Option 2",
                        'opt3'     => "Option 3",
                        'opt4'     => "Option 4",
                    ],
                    'value'             => isset($data["example5"]) ? $data["example5"] : "opt2",
                ],
                'example6'          => [
                    'name'              => "Circular(Radio) Button 1",
                    'description'       => "Circular(Radio) Button 1",
                    'width'             => 40,
                    'description_pos'   => 'L',
                    'is_tooltip'        => true,
                    'type'              => "radio",
                    'options'           => "Option 1,Option 2,Option 3,Option 4",
                    'value'             => isset($data["example6"]) ? $data["example6"] : "Option 2",
                ],
                'example7'          => [
                    'name'              => "Circular(Radio) Button 2",
                    'description'       => "Circular(Radio) Button 2 Description",
                    'description_pos'   => 'L',
                    'is_tooltip'        => true,
                    'type'              => "radio",
                    'options'           => [
                        'opt1'     => "Option 1",
                        'opt2'     => "Option 2",
                        'opt3'     => "Option 3",
                        'opt4'     => "Option 4",
                    ],
                    'value'             => isset($data["example7"]) ? $data["example7"] : "opt2",
                ],
                'example8'          => [
                    'name'              => "Text Area",
                    'description'       => "Text Area Description",
                    'rows'              => "3",
                    'type'              => "textarea",
                    'value'             => isset($data["example8"]) ? $data["example8"] : "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
                    'placeholder'       => "sample placeholder",
                ],
            ];
        }

        public function create($order_options=[])
        {
            try
            {
                /*
                 * $order_options or $this->order["options"]
                * for parameters: https://docs.wisecp.com/en/kb/product-module-development-parameters
                * Here are the codes to be sent to the API...
                */
                $result = "OK";
            }
            catch (Exception $e){
                $this->error = $e->getMessage();
                self::save_log(
                    'Product',
                    $this->_name,
                    __FUNCTION__,
                    ['order' => $this->order],
                    $e->getMessage(),
                    $e->getTraceAsString()
                );
                return false;
            }

            /*
            * Error Result:
            * $result             = "Failed to create server, something went wrong.";
            */
            if(substr($result,0,2) == 'OK')
                return true; /* boolean or array [ 'config' => [...],'creation_info' => [...],]  */
            else
            {
                $this->error = $result;
                return false;
            }
        }

        public function renewal($order_options=[])
        {
            try
            {
                /*
                 * $order_options or $this->order["options"]
                * for parameters: https://docs.wisecp.com/en/kb/product-module-development-parameters
                * Here are the codes to be sent to the API...
                */
                $result = "OK";
            }
            catch (Exception $e){
                $this->error = $e->getMessage();
                self::save_log(
                    'Product',
                    $this->_name,
                    __FUNCTION__,
                    ['order' => $this->order],
                    $e->getMessage(),
                    $e->getTraceAsString()
                );
                return false;
            }

            /*
            * Error Result:
            * $result             = "Failed to create server, something went wrong.";
            */
            if(substr($result,0,2) == 'OK')
                return true; /* boolean or array [ 'config' => [...],'creation_info' => [...],]  */
            else
            {
                $this->error = $result;
                return false;
            }
        }

        public function apply_updowngrade($product=[]){
            $o_config               = $this->options["config"];
            $o_creation_info        = $this->options["creation_info"];
            $p_creation_info        = $product["module_data"];

            try
            {
                /*
                 * $this->order["options"]
                * for parameters: https://docs.wisecp.com/en/kb/product-module-development-parameters
                * Here are the codes to be sent to the API...
                 *
                $params                 = [
                    ...
                ];

                */
                $result = "OK"; # $api->upgrade($params);
            }
            catch (Exception $e){
                $this->error = $e->getMessage();
                self::save_log(
                    'Product',
                    $this->_name,
                    __FUNCTION__,
                    ['order' => $this->order],
                    $e->getMessage(),
                    $e->getTraceAsString()
                );
                return false;
            }

            /*
            * Error Result:
            * $result             = "Error Message";
            */

            if($result == 'OK')
                return true;
            else
            {
                $this->error = $result;
                return false;
            }
        }

        public function suspend()
        {
            try
            {
                /*
                 * $this->order["options"]
                * for parameters: https://docs.wisecp.com/en/kb/product-module-development-parameters
                * Here are the codes to be sent to the API...
                */
                $result             = "OK";
            }
            catch (Exception $e){
                $this->error = $e->getMessage();
                self::save_log(
                    'Product',
                    $this->_name,
                    __FUNCTION__,
                    ['order' => $this->order],
                    $e->getMessage(),
                    $e->getTraceAsString()
                );
                return false;
            }
            /*
            * Error Result:
            * $result             = "Error Message";
            */

            if($result == 'OK')
                return true;
            else
            {
                $this->error = $result;
                return false;
            }
        }

        public function unsuspend()
        {
            try
            {
                /*
                 * $this->order["options"]
                * for parameters: https://docs.wisecp.com/en/kb/product-module-development-parameters
                * Here are the codes to be sent to the API...
                */
                $result = "OK";
            }
            catch (Exception $e){
                $this->error = $e->getMessage();
                self::save_log(
                    'Product',
                    $this->_name,
                    __FUNCTION__,
                    ['order' => $this->order],
                    $e->getMessage(),
                    $e->getTraceAsString()
                );
                return false;
            }

            /*
            * Error Result:
            * $result             = "Error Message";
            */

            if($result == 'OK')
                return true;
            else
            {
                $this->error = $result;
                return false;
            }
        }

        public function delete()
        {
            try
            {
                /*
                 * $this->order["options"]
                * for parameters: https://docs.wisecp.com/en/kb/product-module-development-parameters
                * Here are the codes to be sent to the API...
                */
                $result = "OK";
            }
            catch (Exception $e){
                $this->error = $e->getMessage();
                self::save_log(
                    'Product',
                    $this->_name,
                    __FUNCTION__,
                    ['order' => $this->order],
                    $e->getMessage(),
                    $e->getTraceAsString()
                );
                return false;
            }

            /*
            * Error Result:
            * $result             = "Error Message";
            */

            if($result == 'OK')
                return true;
            else
            {
                $this->error = $result;
                return false;
            }
        }

        public function clientArea()
        {
            $content    = $this->clientArea_buttons_output();
            $_page      = $this->page;

            if(!$_page) $_page = 'home';

            $content .= $this->get_page('clientArea-'.$_page,['test1' => 'hello world', 'test2' => 'sample var']);
            return  $content;
        }

        public function clientArea_buttons()
        {
            $buttons    = [];

            if($this->page && $this->page != "home")
            {
                $buttons['home'] = [
                    'text' => $this->lang["turn-back"],
                    'type' => 'page-loader',
                ];
            }
            else
            {

                $buttons['custom_transaction'] = [
                    'text'  => 'Run Transaction',
                    'type'  => 'transaction',
                ];

                $buttons['another'] = [
                    'text'  => 'Another Page',
                    'type'  => 'page-loader',
                ];

                $buttons['custom_function'] = [
                    'text'  => 'Open Function',
                    'type'  => 'function',
                    'target_blank' => true,
                ];

                $buttons['another-link'] = [
                    'text'      => 'Another link',
                    'type'      => 'link',
                    'url'       => 'https://www.google.com',
                    'target_blank' => true,
                ];
            }

            return $buttons;
        }

        public function use_clientArea_another(){
            echo Utility::jencode([
                'status' => "error",
                'message' => "Example Error Message",
            ]);
        }

        public function use_clientArea_custom_transaction()
        {
            echo  Utility::jencode([
                'status' => "successful",
                'message' => 'Successful Transaction',
            ]);

            return true;
        }

        public function use_clientArea_custom_function()
        {
            if(Filter::POST("var2"))
            {
                echo  Utility::jencode([
                    'status' => "successful",
                    'message' => 'Successful message',
                ]);
            }
            else
            {
                echo "Content Here...";
            }

            return true;
        }

        public function use_clientArea_SingleSignOn()
        {
            $api_result     = 'OK|bmd5d0p384ax7t26zr9wlwo4f62cf8g6z0ld';

            if(substr($api_result,0,2) != 'OK'){
                echo "An error has occurred, unable to access.";
                return false;
            }

            $token          = substr($api_result,2);
            $url            = 'https://modulewebsite.com/api/access/'.$token;

            Utility::redirect($url);

            echo "Redirecting...";
        }

        public function use_clientArea_webMail()
        {
            $url            = 'https://modulewebsite.com/webmail';

            Utility::redirect($url);

            echo "Redirecting...";
        }


        public function adminArea_buttons()
        {
            $buttons = [];

            $buttons['custom_transaction'] = [
                'text'  => 'Run Transaction',
                'type'  => 'transaction',
            ];
            $buttons['custom_function'] = [
                'text'  => 'Open Function',
                'type'  => 'function',
                'target_blank' => true,
            ];

            $buttons['another-link'] = [
                'text'      => 'Another link',
                'type'      => 'link',
                'url'       => 'https://www.google.com',
                'target_blank' => true,
            ];

            return $buttons;
        }

        public function use_adminArea_custom_transaction()
        {
            echo  Utility::jencode([
                'status' => "successful",
                'message' => 'Successful Transaction',
            ]);

            return true;
        }

        public function use_adminArea_custom_function()
        {
            if(Filter::POST("var2"))
            {
                echo  Utility::jencode([
                    'status' => "successful",
                    'message' => 'Successful message',
                ]);
            }
            else
            {
                echo "Content Here...";
            }

            return true;
        }

        public function adminArea_service_fields(){
            $c_info                 = $this->options["creation_info"];
            $field1                 = isset($c_info["field1"]) ? $c_info["field1"] : NULL;
            $field2                 = isset($c_info["field2"]) ? $c_info["field2"] : NULL;

            return [
                'field1'                => [
                    'wrap_width'        => 100,
                    'name'              => "Field 1",
                    'description'       => "Field 1 Description",
                    'type'              => "text",
                    'value'             => $field1,
                    'placeholder'       => "sample placeholder",
                ],
                'field2'                => [
                    'wrap_width'        => 100,
                    'name'              => "Field 2",
                    'type'              => "output",
                    'value'             => '<input type="text" name="creation_info[field2]" value="'.$field2.'">',
                ],
            ];
        }

        public function save_adminArea_service_fields($data=[]){

            /* OLD DATA */
            $c_info           = $data['old']['creation_info'];
            $o_config           = $data['old']['config'];
            $o_options          = $data['old']['options'];

            /* NEW DATA */

            $n_c_info           = $data['new']['creation_info'];
            $n_config           = $data['new']['config'];
            $n_options          = $data['new']['options'];

            if($n_c_info['field1'] == '')
            {
                $this->error = 'Do not leave Field 1 empty.';
                return false;
            }

            return [
                'creation_info'     => $n_c_info,
                'config'            => $n_config,
                'options'           => $n_options,
            ];
        }

    }