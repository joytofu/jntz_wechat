
$(document).ready(function(e) {

    /*α��ѡ��*/
    $(".sex").find("input").click(function(){
        var index=$(".sex").find("input").index(this);
        $(".sex").find("input").removeClass("active").eq(index).addClass("active");
    });
    /*�������ʱ���ύ*/
    $("#tongyi").click(function(){
        if($("#tongyi")[0].checked==true){
            $("#tijiao")[0].disabled=false;
            $("#tijiao").css('cursor','pointer');
            $("#tijiao").addClass("but");
        }
    });
    /*���������ʱ�����ύ*/
    $("#notongyi").click(function(){
        if($("#notongyi")[0].checked==true){
            $("#tijiao")[0].disabled=true;
            $("#tijiao").css('cursor','');
            $("#tijiao").removeClass("but");

        }
    });


    /*�����һ����ʾע���*/
    $(document).on('click','#tijiao',function(){
        $('#statement').attr('style','display:none');
        $('#form1').removeAttr('style');
    });

    /*��ѡ�μӱ�����ʾ��������*/
    $(document).on('change','#yes',function(){
        if(this.checked==true){
            $('#level').css('display','inline');
            $('#title').val('�μӱ���������');
        }else{
            $('#level').css('display','none');
        }
    });


    $(document).on('change','#reg_form input',function(){

        var $fullname = $.trim($('#fullname').val()).length;
        var $mobile = $.trim($('#mobile').val()).length;
        var $sfz = $.trim($('#sfz').val()).length;
        var $email = $.trim($('#email').val()).length;
        var $address = $.trim($('#address').val()).length;
        var $id_card_right_side = $.trim($('#id_card_right_side').val()).length;
        var $id_card_wrong_side = $.trim($('#id_card_wrong_side').val()).length;
        var $debit_card = $.trim($('#debit_card').val()).length;
        if($fullname>0 && $mobile>0 && $sfz>0 && $email>0 && $address>0 && $id_card_right_side>0 && $id_card_wrong_side>0 && $debit_card>0){
            $('#next2').addClass('but');
            $('#next2')[0].disabled=false;
        }
    });








    /*�����һ���ص�����*/
    $(document).on('click','#last2',function(){
        $('#form1').attr('style','display:none');
        $('#statement1').removeAttr('style');
        $('#statement').removeAttr('style');

    });


    /*�����һ����ʾЭ��*/
    $(document).on('click','#next2',function(){
        $('#form1').attr('style','display:none');
        $('#agreement').removeAttr('style');
    });


    /*�����һ���ص�ע���*/
    $(document).on('click','#last3',function(){
        $('#agreement').attr('style','display:none');
        $('#form1').removeAttr('style');
    });



    $(document).on('click','#submit_btn',function(){
        $('#form1').submit();
    });

    $("#send").click(function(){
        djstime();
    });
    /*��֤�뵹��ʱ*/
    function djstime(){
        var e1=$("#send").first();
        var i=10;
        var interval=setInterval(function(){
            e1.html("ʣ��"+i+"��");
            $("#send").css("line-height","35px");
            i--;
            if(i<0){
                $("#send").css({cursor:"pointer"});
                $("#send").css("line-height","18px");
                e1.html("����<br>��ȡ");
                clearInterval(interval);
            }
        },1000);
    }
});