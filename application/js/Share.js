function Share(purl, ptitle, text) {
    this.purl = purl;
    this.ptitle = ptitle;
    this.text = text;

    var self = this;
    this.vkontakte = function () {
        url = 'http://vkontakte.ru/share.php?';
        url += 'url=' + encodeURIComponent(self.purl);
        url += '&title=' + encodeURIComponent(self.ptitle);
        url += '&description=' + encodeURIComponent(self.text);
        url += '&image=' + encodeURIComponent(self.pimg);
        url += '&noparse=true';
        this.popup(url);
    };
    this.facebook = function () {
        url = 'http://www.facebook.com/sharer.php?';
        url += 'u=' + encodeURIComponent(self.purl);
        url += '&t=' + encodeURIComponent(self.ptitle);
        this.popup(url);
    };
    this.twitter = function () {
        url = 'http://twitter.com/share?';
        url += 'text=' + encodeURIComponent(self.ptitle);
        url += '&url=' + encodeURIComponent(self.purl);
        url += '&counturl=' + encodeURIComponent(self.purl);
        this.popup(url);
    };
    this.googleplus = function () {
        url = 'https://plus.google.com/share?';
        url += 'url=' + encodeURIComponent(self.purl);
        this.popup(url);
    };
    this.popup = function (url) {
        window.open(url, '', 'toolbar=0,status=0,width=626,height=436');
    };
    this.makeImage = function (steps, from, to, is_compete, callback) {
        from = from.length > 36 ? from.substring(0, 35) + "..." : from;
        to = to.length > 36 ? to.substring(0, 35) + "..." : to;

        function roundRect(ctx, x, y, width, height, radius) {
            ctx.beginPath();
            ctx.moveTo(x + radius, y);
            ctx.lineTo(x + width - radius, y);
            ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
            ctx.lineTo(x + width, y + height - radius);
            ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
            ctx.lineTo(x + radius, y + height);
            ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
            ctx.lineTo(x, y + radius);
            ctx.quadraticCurveTo(x, y, x + radius, y);
            ctx.closePath();
            ctx.fill();
        }

        function drawLabel(canvas, context, str1, str2, bottom, color) {
            str2 = " " + str2 + " ";
            var padding = 3;
            var x1 = canvas.width/2 + context.measureText(str1 + str2).width/2;
            var x0 = x1 - context.measureText(str2).width;
            if (str2 != null && str2 != "") {
                context.fillStyle = color;
                roundRect(context, x0 - padding, bottom - 21 - padding, x1 - x0 + padding * 2, 20 + padding * 2, 3);
            }
            context.fillStyle = "#fff";
            context.fillText(str1 + str2, canvas.width/2, bottom);
        }

        var pic = new Image();
        pic.src = "/application/images/background.jpg";
        pic.onload = function() {
            var title = "Поздравляем!";
            var str1 = "Вы завершили свой маршрут! Количество переходов:  ";
            var str2 = "Начальная страница:  ";
            var str3 = "Конечная страница:  ";

            var canvas = document.createElement('canvas');
            canvas.width = 660;
            canvas.height = 286;
            //document.body.appendChild(canvas);
            var context = canvas.getContext('2d');

            var scale = pic.width/canvas.width;
            var height = canvas.height*scale;
            var y = (pic.height - height)/2;
            context.drawImage(pic, 0, y, pic.width, height, 0, 0, canvas.width, canvas.height);

            context.fillStyle = "#fff";
            context.strokeStyle = "#fff";
            context.shadowColor = "rgba(0, 0, 0, 0.5)";
            context.shadowOffsetX = 1;
            context.shadowOffsetY = 1;
            context.shadowBlur = 2;

            context.textAlign = "left";
            context.textBaseline = "top";
            context.font = '24px "Helvetica Neue", Helvetica, Arial, sans-serif';
            context.fillText("WikiWalker", 10, 10);

            context.textAlign = "center";
            context.textBaseline = "bottom";
            context.font = '36px "Helvetica Neue", Helvetica, Arial, sans-serif';
            context.fillText(title, canvas.width/2, 110);

            context.font = '21px "Helvetica Neue", Helvetica, Arial, sans-serif';
            if (!is_compete) {
                drawLabel(canvas, context, str1, steps, 150, "#d9534f");
                drawLabel(canvas, context, str2, from, 180, "#f0ad4e");
                drawLabel(canvas, context, str3, to, 210, "#f0ad4e");
            } else {
                drawLabel(canvas, context, "Вы завершили турнир!", "", 180, "#d9534f");
            }

            var base64img = canvas.toDataURL("image/png");
            callback(base64img);
        }
    }
}

