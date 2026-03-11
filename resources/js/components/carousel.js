class BaseCarousel {

    /* 
    el "settings={}" 
    del constructor nos permite modificar 
    sus atributos 
    */
    el=null;
    items=[];
    size=1;
    gap=0;
    item={
        width: 0,
        gap: 0,
        left: 0,
    };

    constructor(el, settings={}){
       if(!el || el.tagName !== "DIV"){
        console.log("It's not working");
       } else{
        console.log("It's working!!!");
       }

        this.el=el;
        this.items=el.getElementsByClassName("card-test");

        this.init();
        console.log(this);
    }

    async init(){
        this.item.width = await this.getSize();
        await this.build();
    }

    async getSize(){
        let w=this.el.clientWidth;
        w=w/this.size;
        return w;
    }

    async build() {
        for(let i=0; i < this.items.length; i++){
            this.items[i].style.width = this.item.width + "px";
            this.items[i].style.left = (this.item.width * i) + "px";
        }
    }

}

const el = document.getElementById("carousel");
if (el) {
    new BaseCarousel(el);
}