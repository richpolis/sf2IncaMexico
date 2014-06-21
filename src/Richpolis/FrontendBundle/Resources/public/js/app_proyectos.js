window.Proyectos = {};

Proyectos.Views = {};
Proyectos.Collections = {};
Proyectos.Models = {};
Proyectos.Routers = {};

window.routers = {};
window.models = {};
window.views = {};
window.collections = {};


Proyectos.Models.Proyecto = Backbone.Model.extend({
    defaults: {
      titulo: '',
      descripcion: '',
      slug: '',
      galerias: [],
      seleccionado: false,
      visible: true, 
    }
});

Proyectos.Collections.Proyectos = Backbone.Collection.extend({
    model: Proyectos.Models.Proyecto,
    filtrarResultados: function(empezo,categoria){
        debugger;
        var empezoApp = empezo;
        var categoriaApp = categoria;
        this.each(function (proyecto) {
            debugger;
            var categoria = ( proyecto.get('categoria')==categoriaApp || categoriaApp == 'todos' );
            var rango = (proyecto.get('empezo') >= empezoApp);
            if( rango && categoria){
                proyecto.set({visible: true });
            }else{
                proyecto.set({visible: false });
            }
		});
    },
    /*comparator: function(proyecto){
        return proyecto.get("termino");
    }*/
});



//esta vista es para visualizar el show_template
Proyectos.Views.ItemView = Backbone.View.extend({
    tagName: 'li',
    className: 'proyecto',
    template: swig.compile($("#item_template").html()),
    events: {
        'click figure.imagen':'seleccionarProyecto', 
        'click .og-close': 'cerrarProyecto'
    },
    cerrarProyecto: function(event){
        event.preventDefault();
        this.model.set({seleccionado: false});
    },
    seleccionarProyecto: function(event){
        event.preventDefault();
        $(".og-close").click();
        this.model.set({seleccionado: true});
    },
    initialize: function() {
        this.model.on("change:seleccionado", this.mostrarExpander, this);
        this.model.on("change:visible",this.mostrar,this);
    },
    render: function() {
        var data = this.model.toJSON();
        var html = this.template(data);
        this.$el.html(html);
        return this;
    },
    mostrarExpander: function() {
        var self = this;
        if(this.model.get('seleccionado')){
            var data = this.model.toJSON();
            var template = swig.compile($("#item_seleccionado_template").html())
            var html = template(data);
            this.$el.append(html);
            this.$el.addClass('og-expanded');
            this.$el.find(".og-expander").css({height: '500px'});
            this.iniciarComponentes();
            this.scrollToDown();
        }else{
            this.$el.find(".og-expander").css({height: '0px'})
            this.$el.find(".og-expander").delay(1000).remove();
            this.$el.removeClass('og-expanded');
            this.scrollToUp();
        }
        return this;
    },
    mostrar: function(){
      if(this.model.get("visible")){
          this.$el.fadeIn("slow");
      }else{
          this.$el.fadeOut("fast");
      }  
    },
    iniciarComponentes: function(){
        iniciarSlider();
        iniciarFancybox();
    },
    scrollToDown: function(){
      	//obtenemos la posición en la que se encuentra el botón
        var posicion = this.$el.offset().top;

        //hacemos scroll hasta el botón
        $("html, body").animate({scrollTop:(posicion+30)+"px"},350);  
    },
    scrollToUp: function(){
      	//obtenemos la posición en la que se encuentra el botón
        var posicion = this.$el.offset().top;

        //hacemos scroll hasta el botón
        $("html, body").animate({scrollTop:(posicion-500)+"px"},1000);  
    },
});


//vista collecio que recibe todos los modelos.
Proyectos.Views.ListView = Backbone.View.extend({
    el: 'article.proyectos',
    tagName: 'article',
    //template: swig.compile($("#app_template").html()),
    events: {
        "change #categoriaProyectos": "seleccionarProyectos",
        "change #yearSelect": "yearSelect",
        "click #allYears": "allYears",
    },
    initialize: function(){
        this.$rango = $("#yearSelect");
        this.$categoria = $("#categoriaProyectos");
        this.$allYears = $("#allYears");
    },
    seleccionarProyectos: function(event){
        event.preventDefault();
		this.ocultarViewsItems();
        this.collection.filtrarResultados(this.$rango.val(),this.$categoria.val());
    },
    yearSelect: function(event){
        event.preventDefault();
        debugger;
        if(this.$rango.val()==this.$rango.data('minimo')){
            this.$allYears.fadeOut("fast");
        }else{
            if(!this.$allYears.is(":visible")){
             	this.$allYears.fadeIn("fast");   
            }
        }
        this.ocultarViewsItems();
        this.collection.filtrarResultados(this.$rango.val(),this.$categoria.val());
    },
    allYears: function(event){
        //event.preventDefault();
        debugger;
        var value =document.getElementById("allYears").checked;
        var minimo=0;
        if(value){
            this.$rango.fadeOut("fast");
            $("#slider-range").fadeOut("fast");
            minimo = this.$rango.data("minimo");
        }else{
            if(!this.$rango.is(":visible")){
                this.$rango.fadeIn("fast");
                $("#slider-range").fadeIn("fast");
            }
            minimo = this.$rango.val();
        }
        this.ocultarViewsItems();
        this.collection.filtrarResultados(minimo,this.$categoria.val());        
    },
    AddOne: function(proyecto) {
        var indice = 0;
        
        if(window.views.proyectos && window.views.proyectos.length){
            indice = window.views.proyectos.length;
        }else{
            indice = 0;
            window.views.proyectos = [];
        }

        //if( rango && categoria) {
            window.views.proyectos[indice]= new Proyectos.Views.ItemView({model: proyecto});
            var html = window.views.proyectos[indice].render().el;
            this.$el.find(".contenedorProyectos").append(html); 
        //}    
    },
    render: function() {
        this.renderAll();
        this.iniciarGrid();
        //this.collection.sort();        
        return this;
    },
    renderAll: function(){
        this.borrarViewsItems();
        this.collection.forEach(this.AddOne,this);
        return this;
    },
    borrarViewsItems: function() {
        var indice = 0;
        if(window.views.proyectos && window.views.proyectos.length){
            indice = window.views.proyectos.length;
        }else{
            indice = 0;
            window.views.proyectos = [];
        }
        for(var cont = 0; cont < indice; cont++ ){
            window.views.proyectos[cont].remove();
        }
    },
    iniciarGrid: function(){
      var self = this;
      var $grid = $( '#og-grid' );
	  var $items = $grid.children( 'li' );  
      $grid.imagesLoaded( function() {
			// save item´s size and offset
			self.saveItemInfo( true );
		} );
    },
    saveItemInfo: function( saveheight ) {
        var $grid = $( '#og-grid' );
	  	var $items = $grid.children( 'li' );
        $items.each( function() {
			var $item = $( this );
			$item.data( 'offsetTop', $item.offset().top );
			if( saveheight ) {
				$item.data( 'height', $item.height() );
			}
		} );
	},
    ocultarViewsItems: function() {
        var indice = 0;
        if(window.views.proyectos && window.views.proyectos.length){
            indice = window.views.proyectos.length;
        }else{
            indice = 0;
            window.views.proyectos = [];
        }
        for(var cont = (indice-1); cont > 0; cont-- ){
            if(views.proyectos[cont].model.get("visible")){
                views.proyectos[cont].model.set({visible: false});        
            }
        }
    },
});

Proyectos.Routers.App = Backbone.Router.extend({
    routes: {
        "" : "root"
    },
    root: function() {
        debugger;
        window.views.listview = new Proyectos.Views.ListView({
            collection: window.collections.proyectos,
        });
        views.listview.render();
    },
});