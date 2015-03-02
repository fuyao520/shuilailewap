<?php include("common/inc.php");?>
<?php include("common/head.php");?>
<body>
<?php include("common/global-bar.php");?>

<?php include("common/nav.php");?>
<script type="text/javascript">var www_host = 'http://www.water58.com';</script>
<script type="text/javascript">$('#mn_company a').addClass('on');</script>
    <div class="company">
        <div class="ndy">
            <div class="fl fl-ag-box">
                <h1>企业采购 - 大客户专区</h1>
                <ul>
                    <li>最大优惠折扣</li>
                    <li>专属客户服务</li>
                    <li>全城快速配送</li>
                </ul>
                <div class="number">0755-33552888</div>
                <a href="#" class="join-existing">欢迎通过电话或右侧表格进行采购登记</a>
            </div>
            <div class="fr fr-ag-box">
                <form name="form1" id="form1" method="post" onsubmit="return post_submit(this);">
                    <ul class="login-form box-inp">
                        <li><input type="text" class="txt" name="lnkman" id="lnkman" placeholder="请输入您的姓名（必填）"></li>
                        <li><input type="text" class="txt" name="lnktel" id="lnktel" placeholder="请输入您的座机/手机号码（必填）"></li>
                        <li><input type="text" class="txt" name="company" id="company1" placeholder="请输入公司名称（选填）"></li>
                        <li><textarea name="content" class="txt text" id="content" placeholder="请输入您的购买需求（选填）"></textarea></li>
                        <li>
                            <button type="submit" class="loginBtn">提交采购意向</button>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
    <div style="width:100%;height:320px;background:#fff;margin:0">
        <div class="company-b">
            <ul>
                <li>
                    <span class="icons con-3"></span>
                    <div class="description">
                        <h4>最大优惠折扣</h4>
                        <p>平台为大客户提供大幅度让利，采购数量越多可享受的折扣越多！</p>
                    </div>
                </li>
                <li>
                    <span class="con-1 icons"></span>
                    <div class="description">
                        <h4>全城快速配送</h4>
                        <p>覆盖全城各大区域，24小时内完成配送，企业饮水从此无忧</p>
                    </div>
                </li>
                <li>
                    <span class="con-2 icons"></span>
                    <div class="description">
                        <h4>专属客户服务</h4>
                        <p>大客户专属客服联系渠道，随时随地接收企业订单，优先享受服务</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <script type="text/javascript">
        function post_submit(o){
            var lnkman = o.lnkman.value;
            var lnktel = o.lnktel.value;
            var company = o.company.value;
            var content = o.content.value;
            if(lnkman == ''){
                alert('请输入您的姓名！');
                o.lnkman.focus();
                return false;
            }
            if((/^1[3458]\d{9}$/.test(lnktel) == false && /^0755-\d{7,8}$/.test(lnktel) == false)){
                alert('请输入您正确的联系方式！');
                o.lnktel.focus();
                return false;
            }
            $.ajax({
                url:"/post/purchase",
                type:"post",
                data:{"lnkman":lnkman,"lnktel": lnktel, "company":company, "content":content},
                success:function(res){
                    var result=eval("("+res+")");
                    if( result.state>0 ){
                        alert('您的留言已经提交成功，我们的客服会尽快答复您！');
                        o.reset();
                    }else{
                        alert(res.msgwords);
                        return;
                    }
                }
            });
            return false;
        }
    </script>
    
<?php include("common/foot.php");?>


</body>
</html>