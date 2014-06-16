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
    }
});

Proyectos.Collections.Proyectos = Backbone.Collection.extend({
    model: Proyectos.Models.Proyecto,
});

//esta vista es para visualizar el show_template
Proyectos.Views.ItemView = Backbone.View.extend({
    tagName: 'div',
    className: 'proyecto',
    template: swig.compile($("#item_template").html()),
    events: {
        'click figure.imagen':'seleccionarProyecto', 
        'click .closeProyecto': 'normalProyecto'
    },
    normalProyecto: function(){
        this.model.set({seleccionado: false});
    },
    seleccionarProyecto: function(){
        this.model.set({seleccionado: true});
    },
    initialize: function() {
        this.model.on("change:seleccionado", this.render, this);
    },
    render: function() {
        if(!this.model.get('seleccionado')){
            var data = this.model.toJSON();
            var html = this.template(data);
            this.$el.html(html);
            this.$el.removeClass('seleccionado col-lg-10');    
            this.$el.addClass('col-lg-4');
        }else{
            this.renderSeleccionado()
        }
        return this;
    },
    renderSeleccionado: function() {
        var data = this.model.toJSON();
        var template = swig.compile($("#item_seleccionado_template").html())
        var html = template(data);
        this.$el.html(html);
        this.$el.addClass('seleccionado col-lg-10');    
        this.$el.removeClass('col-lg-4');
        this.iniciarComponentes();
        return this;
    },
    iniciarComponentes: function(){
        iniciarSlider();
        iniciarFancybox();
    }
});


//vista collecio que recibe todos los modelos.
Proyectos.Views.ListView = Backbone.View.extend({
    el: 'article.proyectos',
    tagName: 'article',
    //template: swig.compile($("#app_template").html()),
    events: {
        "change #categoriaProyectos": "search",
        "change #rangoProyectos": "search"
    },
    search: function(event){
        event.preventDefault();
        this.render();
    },
    AddOne: function(proyecto) {
        var indice = 0;
        var categoria = ( proyecto.get('categoria')==this.categoria || this.categoria == 'todos' );
        var rango = (proyecto.get('empezo') >= this.empezo);
        
        if(window.views.proyectos && window.views.proyectos.length){
            indice = window.views.proyectos.length;
        }else{
            indice = 0;
            window.views.proyectos = [];
        }

        if( rango && categoria) {
            window.views.proyectos[indice]= new Proyectos.Views.ItemView({model: proyecto});
            var html = window.views.proyectos[indice].render().el;
            this.$el.find(".contenedorProyectos").append(html); 
        }    
    },
    render: function() {
        this.empezo = $("#rangoProyectos").val();
        this.categoria = $("#categoriaProyectos").val();
        this.renderAll();
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