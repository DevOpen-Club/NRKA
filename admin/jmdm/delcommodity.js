// // 使用 XMLHttpRequest 创建异步请求对象
            // var xhr = new XMLHttpRequest();

            // // 设置请求方法和URL
            // var url = "delcommodity.php?commodity_id=" + commodity_id + "&user=" + user + "&key=" + md5(btoa(encodeURIComponent(commodity_id + user)));
            // xhr.open("GET", url, true);

            // // 定义请求完成时的回调函数
            // xhr.onreadystatechange = function () {
            //     if (xhr.readyState === 4 && xhr.status === 200) {
            //         // 请求成功，显示服务器返回的结果
                    
            //     } else if (xhr.readyState === 4) {
            //         // 请求出错或失败，显示错误信息
            //         alert("Error: " + xhr.status);
            //     }
            // };

            // // 发送请求
            // xhr.send();