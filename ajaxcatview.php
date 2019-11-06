//javascript
<script type="text/javascript">
   $('#country').click(function(){
       $.ajax({
           url:"{{url('publish/')}}",
           method:"get",
           success:function(data){
            console.log(data)
               $('#app').html(data.view);
           }
       });
   });
</script>


/// Controller
    public function publish()
    {
        $users = User::where('public' ,1)->get();;

        $view=view('public',compact('users'))->render();
        
        return response()->json(['view'=>$view]);
    }
