<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\HelloRequest;
use Illuminate\Support\Facades\Validator;



global $head,$style,$body,$end;

$head = "<html><head>";
$style = <<<EOF
<style>
body{
    font-size: 16pt;
    color: #eee;
}
h1{
    font-size: 100pt;
    text-align: right;
    color: #eee;
</style>
EOF;
$body = "</head><body>";
$end = "</body></html>";

function tag($tag,$txt){
    return "<{$tag}>" . $txt . "</{$tag}>";

}

class HelloController extends Controller
{
    public function index($id = "noname", $pass = "unknown")
    {
        global $head, $style, $body, $end;

        $html = $head . tag("title", "Hello/Index") . $style .
            $body
            . tag("h1", "Index") . tag('p', "this is Index page")
            . "<a href='hello7/other'> go to other page</a>"
            . $end;
        return $html;

    }

    public function other()
    {
        global $head, $style, $body, $end;

        $html = $head . tag("title", "Hello7/other") . $style .
            $body
            . tag("h1", "Other") . tag("p", "this is other page")
            . $end;
        return $html;
    }

    public function index2(Request $request, Response $response)
    {
        global $head, $style, $body, $end;

        $html = $head . tag("title", "Hello/Index") . $style .
            $body
            . tag("h1", "Request")
            . tag("pre", "{$request}")
            . tag("h1", "Response")
            . tag("pre", "{$response}")
            . $end;
        return $html;

    }

    public function index4()
    {
        $data = ["msg" => "これはコントローラから渡されたメッセージです"];
        return view("hello.index", $data);

    }

    public function index5($id = "zero")
    {
        $data = ["msg" => "これはコントローラから渡されたメッセージです",
            "id" => $id];
        return view("hello.index", $data);

    }

    public function index6(Request $request)
    {
        //クエリ?id=testを入力したため、$request->idにtestが代入される
        $data = ["msg" => "これはコントローラから渡されたメッセージです",
            "id" => $request->id];
        return view("hello.index", $data);

    }

    public function index7()
    {
        $data = ["msg" => "これはbladeを利用したサンプルです",
        ];
        //同名のviewファイルがあった場合、bladeの方がアクセスを優先される。
        return view("hello.index", $data);

    }

    public function index8()
    {
        $data = ["msg" => "お名前を入力してください",
        ];
        return view("hello.index", $data);

    }

//    public function post(Request $request)
//    {
//        //編巣msgにインスタンスrequestの変数msgを代入
//        $msg = $request->msg;
//
//        $data = ["msg" => $msg];
//        return view("hello.index", $data);
//    }

    public function index9()
    {
        $data = ["msg" => ""];
        return view("hello.index", $data);

    }

    public function index10()
    {
        return view("hello.index2");

    }

    public function index11()
    {
        //連想配列
        $data = [
            ["name" => "eache", "mail" => "ekugio@com"],
            ["name" => "eache2", "mail" => "ekugio@com"],
            ["name" => "eache3", "mail" => "ekugio@com"]
        ];
        //??普通に$dataを渡すのではだめなのか??なぜだろう
        return view("hello.index2", ["data" => $data]);

    }

    public function index12()
    {
        $data = [
            ["name" => "eache", "mail" => "ekugio@com"],
            ["name" => "eache2", "mail" => "ekugio@com"],
            ["name" => "eache3", "mail" => "ekugio@com"]
        ];
        return view("hello.index2", ["message" => "Hello!"], ["data" => $data]);

    }

    public function index13(Request $request)
    {
        return view("hello.index3", ["data" => $request->data]);
    }

    public function index14(Request $request)
    {
        return view("hello.index4", ["msg" => "フォームを入力"]);
    }
//    public function post(Request $request){
//        //検証ルール。"項目"=>"割り当てるルール"の形式
//        $validate_rule = [
//            "name"=>"required",
//            "mail"=>"email",
//            "age"=>"numeric|between:0,150",
//        ];
//        //validateはコントローラに標準実装されているメソッド。リクエストと検証ルールを引数に持つ
//        $this->validate($request,$validate_rule);
//        return view("hello.index4",["msg"=>"正しく入力されました"]);
//    }

//HelloRequestをuse宣言。
//引数をRequestクラスからHelloRequestクラスに変更することで、HelloRequestクラスのバリデーションが実行される
//    public function  post(HelloRequest $request){
//        return view("hello.index4",["msg"=>"正しく入力されました"]);
//    }

//validatorクラスを使用することで、エラー発生時の挙動を変更できる。いままではエラーメッセージの表示のみだった
//    public function post(Request $request){
//        //Validator::make(値の配列,ルールの配列,エラーメッセージ配列)
//        $validator = Validator::make($request->all() , [
//            "name"=>"required",
//            "mail"=>"email",
//            "age"=>"numeric|between:0,150",
//            ],
//            [
//                "name.required"=>"必須です",
//                "mail.email"=>"Eメール",
//                "age.numeric"=>"整数です",
//                "age.between"=>"0から150の間です"
//            ]
//        );
//        //入力に不備があったらリダイレクトさせる
//        if($validator->fails()){
//            return redirect("/hello19")
//                //エラーメッセージを付与
//                ->withErrors($validator)
//                //入力情報を付与
//                ->withInput();
//        }
//        return view("hello.index4",["msg"=>"正しく入力されました"]);
//    }

    //Validatorはフォーム以外の値もチェックできる。下記はGetアクセスのクエリーの値を検証する例
    public function  index15(Request $request){
        //リクエストのクエリー"$request->query()"のidとpassを検証。
        //$request->query()は、クエリー文字を配列にまとめたものを返す。
        $validator = Validator::make($request->query(),[
            "id"=>"required",
            "pass"=>"required",
        ]);
        if($validator->fails()){
            $msg = "クエリ―に問題があります";
        }else{
            $msg = "ID/PASSを受け付けました。フォームを入力してください";
        }
        return view("hello.index4",["msg"=>$msg]);
    }
//        public function post(Request $request){
//        $message = [
//            "name.required"=>"必須です",
//            "mail.email"=>"Eメール",
//            "age.numeric"=>"整数です",
//            "age.between"=>"0から150の間です"
//        ];
//
//        $rules = [
//            "name"=>"required",
//            "mail"=>"email",
//            "age"=>"numeric|between:0,150",
//        ];
//
//        $validator = Validator::make($request->all() , $rules,$message);
//
//        //条件によって検証ルールを追加したい場合はsometimesメソッドを使う
//        //$validator->sometimes(項目名,ルール名,クロージャ。ルールを追加すべきか決定する)
//        $validator->sometimes("age","min:0",function ($input){
//            return !is_int($input->age);
//        });
//
//        $validator->sometimes("age","max:200",function ($input){
//            return !is_int($input->age);
//        });
//
//        //入力に不備があったらリダイレクトさせる
//        if($validator->fails()){
//            return redirect("/hello19")
//                //エラーメッセージを付与
//                ->withErrors($validator)
//                //入力情報を付与
//                ->withInput();
//        }
//        return view("hello.index4",["msg"=>"正しく入力されました"]);
//    }
//    public function post(HelloRequest $request){
//        return view("hello.index4",["msg" => "正しく入力されました"]);
//    }

    public function index16(Request $request){
        if($request->hasCookie("msg")){
            //クッキーは保存するときresponse。取得するときはrequestインスタンスのメソッドになる
            $msg ="Cookie" . $request->cookie("msg");
        }else{
            $msg="クッキーはありません";
        }
        return view("hello.index",["msg"=>$msg]);
    }

    public function post(Request $request){
        $validate_rule = [
            "msg"=>"required"
        ];
        $this->validate($request,$validate_rule);
        $msg = $request->msg;
        $response = response()->view("hello.index5",["msg"=>$msg."をクッキーに保存しました"]);
        //$response->cookie(キー,値,分数);　クッキーを保存
        $response->cookie("msg",$msg,100);
        return $response;
    }
}
