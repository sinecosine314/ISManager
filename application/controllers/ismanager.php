<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ISManager extends CI_Controller
{
    function __construct()
    {
        // Construct our parent class
        parent::__construct();
    }

    public function changealbum()
    {
        $albumId = $this->input->post ( 'inputAlbumId', true );
        $albumName = $this->input->post ( 'inputAlbumName', true );
        $albumDescription = $this->input->post ( 'inputAlbumDescription', true );

        log_message ( 'debug', "Album ID: $albumId, Album Name: $albumName, Album Description: $albumDescription" );

        $retXml = $this->curl->simple_post
                    (
                        "http://localhost:8888/ImageServer-1.0.0/api/albums/id/$albumId",
                        array
                        (
                            'title'=> $albumName,
                            'description' => $albumDescription
                        )
                    );

        log_message ( 'debug', "Returned XML: $retXml" );
    }

    public function editalbum ( $pAlbumId )
    {
        $retXml = $this->curl->simple_get ( "http://localhost:8888/ImageServer-1.0.0/api/albums/id/$pAlbumId" );

        log_message ( 'debug', "Returned XML: $retXml" );

        $html = $this->_parse_albumId_xml_into_html ( $retXml );

        // Because we cannot carry the html on to the next page, we write it to
        // a file that will be read by the view.
        //log_message ( 'debug', "Current working dir: " . getcwd() );
        file_put_contents ( getcwd() . '/application/views/view_album_info.php', $html );

        redirect ( $this->_this_site_url ( 'ismanager/view/editalbum' ) );
    }

    public function forgot()
    {
        $email = $this->input->post ( 'email' );

        $forgotten = $this->ion_auth->forgotten_password();

        if ( $forgotten )
        {
            // If there were no errors we should display a confirmation page
            // here instead of the login page
            redirect ( $this->_this_site_url ( 'ismanager/view/login' ) );
        }
        else
        {
            redirect ( $this->_this_site_url ( 'ismanager/view/forgot' ) );
        }
    }

    public function home()
    {
        $retXml = $this->curl->simple_get ( 'http://localhost:8888/ImageServer-1.0.0/api/albums' );

        log_message ( 'debug', "Returned XML: $retXml" );

        $html = $this->_parse_albums_xml_into_html ( $retXml );

        // Because we cannot carry the html on to the next page, we write it to
        // a file that will be read by the view.
        //log_message ( 'debug', "Current working dir: " . getcwd() );
        file_put_contents ( getcwd() . '/application/views/view_albums_data.php', $html );

        redirect ( $this->_this_site_url ( 'ismanager/view/home' ) );
    }

    public function index()
    {
        redirect ( $this->_this_site_url ( 'ismanager/view/index' ) );
    }

    public function login()
    {
        $email = $this->input->post ( 'inputEmail', true );
        $password = $this->input->post ( 'inputPassword', true );
        $remember = $this->input->post ( 'checkboxRemember', true );

        log_message ( 'debug', "Email: $email, Password: $password, Remember: $remember" );

        $loggedIn = $this->ion_auth->login ( $email, $password, $remember );

        if ( $loggedIn )
            redirect ( $this->_this_site_url ( 'ismanager/home' ) );
        else
            redirect ( $this->_this_site_url ( 'ismanager/view/login' ) );
    }

    public function logout()
    {
        $this->ion_auth->logout();
        redirect ( $this->_this_site_url ( 'ismanager/view/index' ) );
    }

    public function register()
    {
        $firstName = $this->input->post ( 'inputFirstName', true );
        $lastName = $this->input->post ( 'inputLastName', true );
        $email = $this->input->post ( 'inputEmail', true );
        $telephone = $this->input->post ( 'inputTelephone', true );
        $password = $this->input->post ( 'inputPassword', true );
        $confirm = $this->input->post ( 'inputConfirm', true );

        $msg  = "First name: $firstName, Last name: $lastName, Email: $email, ";
        $msg .= "Telephone: $telephone, Password: $password, Confirm: $confirm.";
        log_message ( 'debug', $msg );

        $username = $email;
        $additional_data = array
        (
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => $telephone
        );

        // Sets user to admin. No need for array('1', '2') as user is always
        // set to member by default
        $group = array ( '1' );
        $registered = $this->ion_auth->register ( $username, $password, $email, $additional_data, $group );

        if ( $registered )
            redirect ( $this->_this_site_url ( 'ismanager/view/login' ) );
        else
            redirect ( $this->_this_site_url ( 'ismanager/view/register' ) );
    }

    /**
     * Page displayer method.
     * @param string $pPage The name of the view to load.
     */
    public function view ( $pPage, $pParm=null )
    {
        $view = '';
        $data = array();

        $loggedIn = $this->ion_auth->logged_in();

        switch ( $pPage )
        {
            case 'editalbum':
                // @todo Remove comments in production code
//                if ( !$loggedIn )
//                {
//                    redirect ( base_url() . 'ismanager/view/login' );
//                }

                // Get the album information from the file
                $filename = getcwd() . '/application/views/view_album_info.php';
                if ( file_exists ( $filename ) )
                    $data['html'] = file_get_contents( $filename );
                else
                    $data['html'] = '<p>No albums found.</p>';

//                $data['custom_template'] = 'signin.css';
                $data['custom_template'] = 'theme.css';
                $data['theme'] = 'bootstrap-theme.min.css';
                //$data['loggedin'] = $loggedIn;
                $data['loggedin'] = true;
                $view = 'view_album_edit';
                break;

            case 'forgot':
                $data['custom_template'] = 'signin.css';
                $data['theme'] = '';
                $data['loggedin'] = $loggedIn;
                $view = 'view_forgot';
                break;

            case 'home':
                // @todo Remove comments in production code
//                if ( !$loggedIn )
//                {
//                    redirect ( base_url() . 'ismanager/view/login' );
//                }

                // Get the album information from the file
                $filename = getcwd() . '/application/views/view_albums_data.php';
                if ( file_exists ( $filename ) )
                    $data['html'] = file_get_contents( $filename );
                else
                    $data['html'] = '<p>No albums found.</p>';

                $data['custom_template'] = 'theme.css';
                $data['theme'] = 'bootstrap-theme.min.css';
//                $data['loggedin'] = $loggedIn;
                $data['loggedin'] = true;
                $view = 'view_home';
                break;

            case 'index':
                $data['custom_template'] = 'starter-template.css';
                $data['theme'] = '';
                $data['loggedin'] = $loggedIn;
                $view = 'view_landing';
                break;

            case 'login':
                $data['custom_template'] = 'signin.css';
                $data['theme'] = '';
                $data['loggedin'] = $loggedIn;
                $view = 'view_login';
                break;

            case 'register':
                $data['custom_template'] = 'signin.css';
                $data['theme'] = '';
                $data['loggedin'] = $loggedIn;
                $view = 'view_register';
                break;

            default:
                $data['custom_template'] = 'starter-template.css';
                $data['theme'] = '';
                $data['loggedin'] = $loggedIn;
                $view = 'view_landing';
                break;
        }

        // Load the view
        $this->load->view ( $view, $data );
    }

    private function _this_site_url ( $pUrlEnd )
    {
        return base_url() . $pUrlEnd;
    }

    private function _parse_xml_into_array ( $pXmlStr )
    {
        // Create an XML parser to process the results, parse the XML into an
        // array and free the parse
        $p = xml_parser_create();
        xml_parse_into_struct ( $p, $pXmlStr, $vals, $index );
        xml_parser_free ( $p );

        log_message('debug', print_r ( $vals,true ) );

        return array ( 'vals' => $vals, 'index' => $index );
    }

    private function _parse_albums_xml_into_html ( $pXml )
    {
        $arr = $this->_parse_xml_into_array ( $pXml );
log_message('debug', print_r($arr,true));

        // Process the array containing the resuts from the XML by putting the
        // data into a <div> with <summary> and <detail> elements
        //
        // An array record should look like this:
        // Array
        // (
        //     [tag] => ALBUMID
        //     [type] => complete
        //     [level] => 3
        //     [value] => 1
        // )
        //
        // Elements we want to include in the display should have a type of
        // complete and level of 3.

        $html = '';
        $albums = array();
        foreach ( $arr['vals'] as $val )
        {
            // Initialize the data array if on a <item> element
            if ( $val['tag'] == 'ITEM' && $val['type'] == 'open' && $val['level'] == 2 )
            {
                $albums = array();
            }

            // Add the element to the data array if the right element
            if ( $val['type'] == 'complete' && $val['level'] == 3 )
            {
                if ( isset ( $val['value'] ) )
                {
                    $value = $val['value'];
                }
                else
                {
                    $value = 'unknown';
                }
                $albums[strtolower($val['tag'])] = $value;
            }

            // On the </item>, build the html
            if ( $val['tag'] == 'ITEM' && $val['type'] == 'close' && $val['level'] == 2 )
            {
                $html .= '      <tr>';
                $html .= "        <td>{$albums['albumid']}</td>";
                $html .= "        <td>{$albums['albumtitle']}</td>";
                $html .= "        <td>{$albums['albumdescription']}</td>";
                $html .= '        <td>';
                $html .= '          <a href="' . $this->_this_site_url ( 'ismanager/editalbum/' ) . $albums['albumid'] . '"><img src="' . img_url() . 'pencil-2x.png' . '" alt="Edt" title="Edit the album"></a>&nbsp;';
                $html .= '          <a href="' . $this->_this_site_url ( 'ismanager/deletealbum/' ) . $albums['albumid'] . '"><img src="' . img_url() . 'delete-2x.png' . '" alt="Del" title="Delete the album"></a>&nbsp;';
                $html .= '          <a href="' . $this->_this_site_url ( 'ismanager/addimages/' ) . $albums['albumid'] . '"><img src="' . img_url() . 'image-2x.png' . '" alt="Img" title="Images the album"></a>';
                $html .= '        </td>';
                $html .= '      </tr>';
            }
        }

        return $html;
    }

    private function _parse_albumId_xml_into_html ( $pXml )
    {
        $arr = $this->_parse_xml_into_array ( $pXml );

        // Process the array containing the resuts from the XML
        //
        // An array record should look like this:
        // Array
        // (
        //     [tag] => ALBUMID
        //     [type] => complete
        //     [level] => 2
        //     [value] => 200
        // )
        //
        // Elements we want to include in the display should have a type of
        // complete and level of 2.

        $html   = '';
        foreach ( $arr['vals'] as $val )
        {
            // Add the element to the data array if the right element
            if ( $val['type'] == 'complete' && $val['level'] == 2 )
            {
                $value = 'unknown';
                if ( isset ( $val['value'] ) )
                {
                    $value = $val['value'];
                }

                if ( $val['tag'] == 'ALBUMID' )
                {
                    $html .= '<input type="hidden" name="inputAlbumId" value="' . $value . '">';
                }
                else if ( $val['tag'] == 'ALBUMTITLE' )
                {
                    $html .= '<label for="inputAlbumName" class="sr-only">Album Name</label>';
                    $html .= '<input type="text" name="inputAlbumName" id="inputAlbumName" class="form-control" value="' . $value . '" required autofocus>';
                }
                else if ( $val['tag'] == 'ALBUMDESCRIPTION' )
                {
                    $html .= '<label for="inputAlbumDescription" class="sr-only">Album Description</label>';
                    $html .= '<input type="text" name="inputAlbumDescription" id="inputAlbumDescription" class="form-control" value="' . $value . '" required autofocus>';
                }
                else
                {
                }
            }
        }

        log_message ( 'debug', "html = $html" );

        return $html;
   }

}

/* End of file ismanager.php */
/* Location: ./application/controllers/ismanager.php */
