<?php

namespace App\Http\Controllers\Ticket;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\BitacoraClass;
use App\Models\Product\Product;
use App\Models\Product\ProductAction;
use App\Models\General\Money;
use App\Models\Product\Price;
use Illuminate\Support\Facades\DB;
use App\Classes\MainClass;
use App\Models\General\Rol_permissions;
use App\Models\General\Main;
use \stdClass;

class ProductController extends Controller
{
  public function __construct(){
		$this->middleware('auth');
	}

  public function ProductPermisos(){
    $a = new stdClass();

    $a->create = false;
    $a->view = false;
    $a->edit = false;
    $a->delete = false;
    $a->reporte = false;
    $a->add = false;

    return $a;
  }

  public function index(){
    $main = new MainClass();
    $main = $main->getMain();

    $t = $this->PermisosProducts();
    $permisover = $t->view;
    $permisocrear = $t->create;
    $rolid = $t->rolid;

    $money    = Money::WHERE('status_user', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');


    if ($permisover == true || $rolid == 4){
      return view('product.index', compact( 'money', 'main','permisocrear','rolid'));
    }else{
      return view('errors.403', compact('main'));
    }

  }

  function insertProduct($a)
  {

      try
      {
        DB::beginTransaction();
        $p = [
          'cod_product'      =>  $a->cod_product,
          'name_product'       =>  $a->name_product,
          'description'             =>  $a->description,
          'modified_by'  =>  auth()->user()->id
        ];
        $idp= Product::create($p)->id;

        $pa = [
          'id_product'      =>  $idp,
          'cant'             =>  $a->cant,
          'id_money' => $a->id_money,
          'purchase_price'=>$a->price_venta,
          'sale_price' => $a->sale_price,
          'modified_by'      => auth()->user()->id
        ];

        ProductAction::create($pa);

        $pr =[
          'id_product' => $idp,
          'id_money' =>$a->id_money,
          'price' =>$a->sale_price,
          'description' =>$a->description,
          'note'=> $a->note,
          'modified_by'=> auth()->user()->id,
          'status_user'=>1
        ];
        Price::create($pr);

        DB::commit();
      return   response()->json([
          "objet"=>"success",
          "message"=> "El Precio se registró correctamente"
        ]);

      }
      catch (\Exception $e)
      {
        DB::rollback();
          return response()->json([
            "objet"=>"error",
            "message"=> $e->getMessage()
          ]);
      }
  }

  function insertPrice($a)
  {
    try
    {
      DB::beginTransaction();
      $pr =[
        'id_product' => $a->id_product,
        'id_money' =>$a->id_money,
        'price' =>$a->price,
        'description' =>$a->description,
        'note'=> $a->note,
        'modified_by'=> auth()->user()->id,
        'status_user'=>1
      ];
      Price::create($pr);

      DB::commit();
    return   response()->json([
        "objet"=>"success",
        "message"=> "El Precio se registró correctamente"
      ]);

    }
    catch (\Exception $e)
    {
      DB::rollback();
        return response()->json([
          "objet"=>"error",
          "message"=> $e->getMessage()
        ]);
    }
  }

  public function saveProduct()
  {
    $a= new stdClass();
    $a->cod_product      =  request()->cod_product;
    $a->name_product       =  request()->name_product;
    $a->description = request()->description;
    $a->cant            =  request()->cant;//cantidad de acciones
    $a->id_money = request()->id_money;
    $a->purchase_price=request()->price;
    $a->sale_price = request()->price;
    $a->price_venta=request()->price;
    $a->price =request()->price;
    $a->note= "Registro";
    $a->status_user=1;
    return $this->insertProduct($a);
  }

  public function savePrice()
  {
    $a= new stdClass();
    $a->id_product =  request()->id;
    $a->id_money = request()->money;
    $a->price =request()->price;
    $a->description ="Precio";
    $a->note = "Registro";
    if($this->validatePrice($a))
    {
      return response()->json([
        "objet"=>"error",
        "message"=> "Ya existe el precio ingresado."
      ]);
    }
    else
    return $this->insertPrice($a);
  }

  function validatePrice($a)
  {
    $r = false;
    $r  = Price::where('id_money',$a->id_money)
    ->where('price', $a->price)
    ->where('id_product', $a->id_product)
    ->exists();

    return $r ;
  }

  public function getProductos(){
    // $productos = Product::where('status_user','1');
    $main = new MainClass();
    $main = $main->getMain();

    $t = $this->PermisosProducts();
    $permisover = $t->view;
    $permisocrear = $t->create;
    $rolid = $t->rolid;

    if ($permisover == true || $rolid == 4){
      return view("product.activarProductos", compact("main","permisocrear","rolid"));
    }else{
      return view('errors.403', compact('main'));
    }
// dd($productos);

  }
  public function getProductoss(){
    $productos = Product::all();

      return response()->json([
        "data"=>$productos
      ]);

  }
  public function updateStatusProducto(request $r){

    $producto = Product::where('id',$r->id)->first();
    $producto->status_user = $r->status;
    $message = "<span> Codigo $producto->cod_product </span>";
    $message .= $producto->name_product;
    if($r->status==1){
      $message .="<span> Está <b>Activado</b> </span>" ;
    }else{
      $message .="<span> Está <b>Desactivado</b> </span>" ;
    }
    $producto->update();


    return response()->json([
      "message"=>$message
    ]);
  }

  public function getProducts()
  {

    $p = Product::where('status_user','1')
    ->with('getPrice','getProductAction')
    ->get();

    $t = $this->PermisosProducts();
    $permisoagregar = $t->add;
    $rolid = $t->rolid;

    $a = [];



    foreach ($p as $key => $value)
    {
      $v =
      [
          "product" => $value,
          "permiso" => $permisoagregar,
          "permisorol" => $rolid,
          "img" => ($value->url_imagen == null)?"<i class='fa fa-fw  fa-upload' onclick='uploadImg(".$value->id.")'/>":"<i class='fa fa-fw fa-edit' onclick='uploadImg(".$value->id.")'/>",
          "visible" => ($value->store)?"<i class='fa fa-fw fa-check' onclick='store(".$value->id.",false)'/>":"<i class='fa fa-fw fa-exclamation'  onclick='store(".$value->id.",true)'/>"
      ];
      array_push($a, $v);
    }
    return response()->json([
      "product"=>$a
    ]);
  }

  function getMoney($f)
  {

      $b = Money::where("id","=",$f)->first();

    return   $b;
  }



  function getPrice_id()
  {
    $id = request()->id;
    $p = Product::where('status_user', "1")
    ->where('id', $id)
    ->first();

    $b = [];
    foreach ($p{'getPrice'} as $key => $value) {
      $a= new stdClass();
      $a->money =  $this->getMoney($value->id_money);
      $a->price = $value->price;
      $a->id = $value->id;
      $a->status_user = $value->status_user;
      array_push($b, $a);
    }
    return $b;
  }

  public function getPrice()
  {
    $p =  Price::where('id',request()->id)->first();
    $b = Money::where("id","=",$p->id_money)->first();

    return response()->json([
      "money"=>$b->id,
      "price"=>$p->price
    ]);
  }

  public function updatePrice()
  {
      $p = Price::where('id', request()->id)->first();
      $p->price = request()->price;
      $p->id_money = request()->id_money;


      $a= new stdClass();
      $a->id_product = request()->id_product;
      $a->id_money = request()->id_money;
      $a->price = request()->price;



      if(!$this->validatePrice($a))
      {
        $p->save();
        return response()->json([
          "objet"=>"success",
          "message"=> "El precio fue actualizado."
        ]);
      }
      else {
        return response()->json([
          "objet"=>"WARNING",
          "message"=> "El precio ya se encuentra registrado."
        ]);
      }
  }

  function deletePrice()
  {
    $p = Price::where('id', request()->id)->first();

      $p->delete();
     return response()->json([
       "objet"=>"success",
       "message"=> "El Precio fue Elimiando"
     ]);
  }


  public function listProductos()
  {
    $pri = Price::all();
    $p = [];
    foreach ($pri as $key => $value)
    {
      $pro = Product::where('id',$value->id_product)

      ->with('getPrice','getProductAction')
      ->first();

       $a= new stdClass();
       $a->product = $pro;
       $a->moneda = $this->getMoney($value->id_money);
       $a->precio = $value;
       if(is_null($pro))
       {
         continue;
       }
      array_push($p, $a);
    }

    return $p;

  }

  public function activarDesactivarProductos(request $r){
    $pro = Product::where('id',$r->id_product)->first();
    // return response()->json(["message"=> $pro->status_system]);
    if($pro->status_system === true){

      $pro->status_system = 'false';
      $pro->save();

    }else if($pro->status_system === false){

      $pro->status_system = 'true';
      $pro->save();
    }else{
      return response()->json([
        "objet"=>"error",
        "message"=> "Ha ocurrido un error al actualizar el producto."
      ]);
    }

    return response()->json([
      "objet"=>"success",
      "message"=> "Actualizado estatus del producto."
    ]);
  }






  public function PermisosProducts(){
    $rol = Main::where('users.id', '=', auth()->user()->id)
      ->where('main.status_user', '=', 'TRUE')
      ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
      ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
      ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
      ->join('users',    'users.id',              '=',   'rol_user.id_user')
      ->select('roles.id','rol_user.id as id_roluser')
      ->first();

    $roluser = $rol{'id_roluser'};

    $t = $this->ProductPermisos();

    $permissions = Rol_permissions::where('id_roluser', '=', $roluser)
                  ->select('id_permission')
                  ->get();

    foreach ($permissions as $rs) {
        if ($rs->id_permission == 20){
           $t->create = true;
        }else if ($rs->id_permission == 21){
           $t->view = true;
        }else if ($rs->id_permission == 22){
           $t->delete = true;
        }else if ($rs->id_permission == 23){
           $t->edit = true;
        }else if ($rs->id_permission == 24){
           $t->reporte = true;
        }else if ($rs->id_permission == 25){
           $t->add = true;
        }
    }

    $t->rolid = $rol{'id'};

    return $t;
  }

function getProduct_id()
{
  $p = Product::where('id',request()->id_product)->first();
  return response()->json([
    "objet"=>"success",
    "data"=> $p
  ]);
}


  function store()
  {
    $p = Product::where('id',request()->id_product)->first();
    $p->store = request()->status;
    $p->save();
    return response()->json([
      "objet"=>"success",
      "message"=> "actualizado."
    ]);
  }

  function imgsave()
  {
    $p = Product::where('id',request()->id_product)->first();
    $p->url_imagen = request()->url_imagen;
    $p->save();
    return response()->json([
      "objet"=>"success",
      "message"=> "actualizado."
    ]);
  }

  function updateStusProduct()
  {
    $p =  Price::where('id',request()->id_precio)->first();
    $p->status_user = request()->status;
    $p->save();
    return response()->json([
      "object"=>"success",
      "menssage"=> "Actualizado."
    ]);
  }

}
