class Ajax {
    
    private _xhr: XMLHttpRequest;

    private static DONE : number;
    private static OK : number;

    public constructor() {
        this._xhr = new XMLHttpRequest();
        Ajax.DONE = 4;
        Ajax.OK = 200;
    }

    public Get = (ruta: string, success: Function, params: string = "", error?: Function):void => {
    
        let parametros:string = params.length > 0 ? params : "";
        ruta = params.length > 0 ? ruta + "?" + parametros : ruta;
        console.log(ruta);
        console.log(params);

        this._xhr.open('GET', ruta);
        this._xhr.send();

        this._xhr.onreadystatechange = () => {

            if (this._xhr.readyState === Ajax.DONE) {
                if (this._xhr.status === Ajax.OK) {
                    //this._xhr.responseText='nombre=Holita,origen=Argentina';
                    //console.log('Este es el xhr:');
                    //console.log(this._xhr);
                    // console.log('Esto es el xhr response text: ');
                    // console.log(this._xhr.responseURL);
                    success(this._xhr.responseText);
                } else {
                    if (error !== undefined){
                        error(this._xhr.status);
                    }
                }
            }

        };
    };


    public Post = (ruta: string, success: Function, params: string | FormData = "", error?: Function):void => 
    {
        this._xhr.open('POST', ruta, true);
        
        if(typeof(params) == "string")
        {
            this._xhr.setRequestHeader("content-type","application/x-www-form-urlencoded");
        }
        else
        {
            this._xhr.setRequestHeader("enctype","multipart/form-data");
        }

        this._xhr.send(params);

        this._xhr.onreadystatechange = ():void => {

            if (this._xhr.readyState === Ajax.DONE)
            {
                if (this._xhr.status === Ajax.OK)
                {
                    success(this._xhr.responseText);
                }
                else
                {
                    if (error !== undefined)
                    {
                        error(this._xhr.status);
                    }
                }
            }
        };
    }; 
}