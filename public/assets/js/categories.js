    function create_tree_categories(options){
    var tree  = [];

    var noone_node = [];
    noone_node.state = [];
    if (options.no_one_name==undefined){
        noone_node.text = "Nenhuma";
    } else {
        noone_node.text = options.no_one_name;
    }
    noone_node.id = "0";
    if (options.selected_id == 0){
        noone_node.state.selected = true;
        $(options.input_result).val('0');
        tree.push(noone_node);
        if (options.continue_childs){
            options.father_id  = 0;
            options.tree = tree;
            recursive_node(options);
        }
    } else {

        if (options.selected_id>-1)
            tree.push(noone_node);
        options.father_id  = 0;
        options.tree = tree;
        recursive_node(options);
    }

    if (options.tree_id==undefined){
        options.tree_id = "tree";
    }

    $('#'+options.tree_id).treeview({
        data: tree,
        levels: 10,
        selectedBackColor: '#3B77AB', 
        onNodeSelected: function(event, data) {
            $(options.input_result).val($('#'+options.tree_id).treeview('getSelected')[0].id);
            $(options.input_result).triggerHandler('change');
        }
    });
}

function recursive_node(options){
    var filtred = [];
    for (var i = 0;i<options.values.length; i++){
        if (options.values[i]['father_id'] == options.father_id){
            filtred.push(options.values[i]);
        }
    }

    for (var i=0; i<filtred.length;i++){
        var no = [];
        no.state = [];
        no.text = filtred[i]['description'];
        no.id = filtred[i]['id'];
        if (options.show_actions){
            no.text += "<p>"+
            "<a class=\"btn btn-sm btn-success-outline\" style=\"margin-top: -5px;\" onclick=\"document.location=this.href\" href='"+options.create_item_page+"/"+no.id+"'> <i class=\"fa fa-plus\"></i> Adicionar "+options.create_item_title+"</a>"+
            "<a class=\"btn btn-sm btn-warning-outline\" style=\"margin-top: -5px;\" onclick=\"document.location=this.href\" href='"+options.update_page+"/"+no.id+"'> <i class=\"fa fa-pencil-square-o\"></i> Editar</a>"+
            "<a class=\"btn btn-sm btn-danger-outline\" style=\"margin-top: -5px;\" onclick=\"document.location=this.href\" href='"+options.delete_page+"/"+no.id+"'> <i class=\"fa fa-times\"></i> Remover</a>"+
            "</p>";
        }

        no.nodes = [];
        if (options.selected_id == no.id){
            no.state.selected = true;
            $(options.input_result).val(options.selected_id);
            options.tree.push(no);
            if (options.continue_childs){
                var old_opt_father_id = options.father_id;
                var old_opt_tree = options.tree;
                options.father_id = filtred[i]['id'];
                options.tree = no.nodes;
                recursive_node(options);
                options.father_id = old_opt_father_id;
                options.tree = old_opt_tree;
            }
        } else {
            options.tree.push(no);
            var old_opt_father_id = options.father_id;
            var old_opt_tree = options.tree;
            options.father_id = filtred[i]['id'];
            options.tree = no.nodes;
            recursive_node(options);
            options.father_id = old_opt_father_id;
            options.tree = old_opt_tree;
        }

        if (no.nodes.length==0){
            delete no.nodes;
        }
    }
}