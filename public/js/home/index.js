function ColorManager(r /* red */ , g /* green */ , b /* blur */ , fatorR, fatorG, fatorB, maxR, maxG, maxB, minR, minG, minB) {
    return {
        r: r,
        g: g,
        b: b,
        fatorR: fatorR,
        fatorB: fatorB,
        fatorG: fatorG,
        maxR: maxR,
        maxG: maxG,
        maxB: maxB,
        minR: minR,
        minG: minG,
        minB: minB,
        toRGBA: function() {
            return "rgba(" + Math.round(this.r) + ", " + Math.round(this.g) + ", " + Math.round(this.b) + ", 1)";
        },
        apply: function() {
            this.r += this.fatorR;
            this.b += this.fatorB;
            this.g += this.fatorG;
            if (this.r > this.maxR || this.r < this.minR) {
                this.r -= this.fatorR;
                this.fatorR = this.fatorR * -1;
            }
            if (this.g > this.maxG || this.g < this.minG) {
                this.g -= this.fatorG;
                this.fatorG = this.fatorG * -1;
            }  
            if (this.b > this.maxB || this.b < this.minB) {
                this.b -= this.fatorB;
                this.fatorB = this.fatorB * -1;
            }
            return this;
        }
    };
};
    
// aqui você faz todas as configurações do Color
var cor1 = new ColorManager(0, 0, 0, 0.5, 0.3, 0.1, 255, 255, 255, 0, 0, 0);
var cor2 = new ColorManager(255, 255, 255, 1, 2, 3, 255, 255, 255, 0, 0, 0);

// cria o timer
setInterval(function() {
    $("body").css({
        background: "linear-gradient(to right, " + cor1.apply().toRGBA() + "," + cor2.apply().toRGBA() + ")"
    });
}, 100);