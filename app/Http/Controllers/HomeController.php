<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Component;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->role == 'admin')
        {
            return view('home');
        }else{
            return 'NON HAI LE AUTORIZZAZIONI';
        }


    }


    public function store(Request $req)
    {

        //dd($req);
        $component = [];

        $namespacemodel = preg_replace('/\s+/', '', $req->namespacemodel);
        $nomemodel = preg_replace('/\s+/', '', $req->nomemodel);

        $nometabelladb = preg_replace('/\s+/', '', $req->nometabelladb);

        $namespacecontroller = preg_replace('/\s+/', '', $req->namespacecontroller);
        $nomecontroller = preg_replace('/\s+/', '', $req->nomecontroller);

        if( Component::where('namespacecontroller',$namespacecontroller)->where('nomecontroller',$nomecontroller)->count() == 0 )
        {
            $component = Component::create([ 'namespacemodel' => $namespacemodel,
                                                'nomemodel' => $nomemodel,
                                                'namespacecontroller' => $namespacecontroller,
                                                'nomecontroller' => $nomecontroller,
                                                'nometabelladb' => $nometabelladb
                                                ]);
        }

        else
            $component = Component::where('nomecontroller',$nomecontroller)->where('namespacecontroller',$namespacecontroller)->get();



        /* Model */
        if(empty($req->namespacemodel))
        {
            $this->generateModel('',$nomemodel, $nometabelladb);

        }else{
            $this->generateModel($namespacemodel, $nomemodel,$nometabelladb);
        }

        /* Controller */
        if(empty($req->namespacecontroller))
        {
            $this->generateController('',$nomecontroller);
        }else{

            $this->generateController($namespacecontroller,$nomecontroller);
        }

        /* View */

        $this->generateView($nomemodel);



        return view('batch.index',['component' => $component]);

    }


    private function generateModel($namespace, $nomemodel, $nometabelladb)
    {
        if(!is_null($nometabelladb) )
        {
            $nometabellaDB = DB::select('describe ' .$nometabelladb );
        }



        $model = '<?php';
        $model .="\n";

        if($namespace != '')
            $model .='namespace App'.'\\'. $namespace .';';
        else
            $model .='namespace App;';

        $model .="\n\n";

        $model .= 'use Illuminate\Database\Eloquent\Model;';

        $model .="\n\n";

        $model .=' class '. ucwords($nomemodel). ' extends Model
        {';

        $model .="\n\n";
        $model .= 'protected $table ="' .$nometabelladb .'";';
        $model .="\n\n";

        $model .='protected $fillable= [';

        $cnt = count($nometabellaDB);
            $i = 1;
            foreach($nometabellaDB as $schema)
            {

                if( !$this->has_prefix($schema->Field, 'created') && !$this->has_prefix( $schema->Field, 'updated') )
                {
                    if($cnt == $i)
                        $model .= "'" . $schema->Field."'";
                    else
                        $model .= "'" . $schema->Field ."',";

                }
                ++$i;
            }

        $model .= '];';
        $model .="\n\n";
        $model .='}
        ?>';

        if($namespace != '')
        {
            $path = '../app/' . $namespace .'/';
            if(!is_dir($path))
            {
                mkdir($path );
                chmod( $path, 777 );
            }

            $file=fopen( $path . ucwords($nomemodel) .'.php','w');
        }

        else
            $file=fopen('../app/'. ucwords($nomemodel) .'.php','w');


        fwrite($file,$model);
        fclose($file);
    }


    private function has_prefix($string, $prefix) {
        return substr($string, 0, strlen($prefix)) == $prefix;
     }

    private function generateController($namespacecontroller, $nomecontroller)
    {
        $content = '<?php';
        $content .="\n";

        if($namespacecontroller != '')
            $content .= 'namespace App\Http\Controllers' .'\\'.  $namespacecontroller .';';
        else
            $content .= 'namespace App\Http\Controllers;';


            $content .="\n";

            $content .='
        use Illuminate\Http\Request;

        class ' . ucwords($nomecontroller) .'Ctrl extends Controller
        {

        }

        ?>';

        if($namespacecontroller != '')
        {
            $path = '../app/Http/Controllers/' . $namespacecontroller .'/' ;
            if(!is_dir($path))
            {
                mkdir($path );
                chmod( $path, 777 );
            }
            $file=fopen( $path . ucwords($nomecontroller) .'.php','w');

        }else{
            $file=fopen('../app/Http/Controllers/'. ucwords($nomecontroller) .'Ctrl.php','w');
        }


        fwrite($file,$content);
        fclose($file);
    }

    private function generateView($nomemodel)
    {

        $path = '../resources/views/' . $nomemodel .'/';
        if(!is_dir($path))
        {
            mkdir($path );
            chmod( $path, 777 );
        }



        $arr = array ("index", "create", "update",  "delete");
        foreach ( $arr as $value )
        {
            $file=fopen( $path . $value .'.php','w');
            $content = '<div class="container"><div class="row"><h1>' .$value .'</h1></div></div>';
            fwrite($file,$content);
            fclose($file);
        }


    }

}
