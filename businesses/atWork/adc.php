<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
<form action="./addcommodity.php" method="post" onsubmit="return validateForm()">
    <div>
        <label for="name">商品名称:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div>
        <label for="price">商品售价（元）:</label>
        <input type="number" id="price" name="price" step="0.01" required>
    </div>
    <div>
        <label for="introduce">商品简介:</label>
        <textarea id="introduce" name="introduce" required></textarea>
    </div>
    <div>
        <label for="introduce">兑换码:</label>
        <textarea id="ka" name="ka" required></textarea>
        <p>请勿填写类似“私信获取”“加我QQ”等兑换码，请填写真实兑换码，否则账户冻结概不负责。</p>
    </div>
    <input type="hidden" id="key" name="key">
    <div>
        <input type="submit" value="提交">
        <input type="reset" value="重置">
    </div>
    <p>注：修改商品图片请联系管理员。点击提交后扣除余额0.1元。</p>
</form>

<script>
    function validateForm() {
        var name = document.getElementById("name").value;
        var price = document.getElementById("price").value;
        var introduce = document.getElementById("introduce").value;
        var ka = document.getElementById("ka").value;

        // 检查是否有填写完整的参数
        if (name === '' || price === '' || introduce === '' || ka==='') {
            alert("请填写完整的参数");
            return false; // 阻止表单的提交
        }

        // 拼接参数值并计算 key
        var key = CryptoJS.MD5(btoa(encodeURIComponent(name +introduce + ka))).toString();

        // 设置隐藏的 key 参数值
        document.getElementById("key").value = key;

        return true; // 允许表单的提交
    }
</script>