    <form id="edit_ventas" autocomplete="off">
       @csrf 
       {{ method_field('PUT') }}
        <div class="modal-header">
            <h4 class="modal-title">Editar</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">   
            <div class="col-md-12">
                <input class="form-control" type="hidden" name="idunic" id="idunic" readonly="readonly"  value="{{$result_edit->id}}">

                <div class="form-group row">
                    <label for="iva_edit" class="col-form-label col-sm-3">Estado:</label>
                    <div class="col-sm-8">
						<select id="estado_edit" name="estado_edit" class="form-contro"  style="width:100%" >
                            @foreach($comboestado_edit as $cb_est_edit)
                                <option value="{{$cb_est_edit->id}}">{{$cb_est_edit->nombre}}</option>
                            @endforeach
                      </select>
                    </div>
                </div>
                
            </div>

    </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" >Guardar</button>
            </div>
</form>

<script type="text/javascript">

    remove_cursor_wait();
    $('#modale').modal();
    $('button[name=editar]').attr('disabled',false);

    $('#estado_edit').val({{$result_edit->id_estado}});
        $('#estado_edit').select2({
      theme: 'bootstrap4'
    })


    var form2=document.getElementById('edit_ventas');

    form2.addEventListener('submit', (event) => {
     event.preventDefault();
   
        const edit_sup = new FormData(form2); 
            $.ajax({
                url:"{{asset('')}}ventas/{{$result_edit->id}}",
                type: 'POST',
                dataType: 'json',
                contentType: false,
                processData: false,
                data: edit_sup,
                success:function(res){
                    if(res.sms){
                         Consultar(); 
                         $('#modale').modal('hide');
                         toastr.success(res.mensaje);                    
                    }
                    else{               
                        Swal.fire({
                            closeOnClickOutside:false,
                            title: res.mensaje,
                            icon: "error",
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                   }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    if (errorThrown=='Unauthorized') {
                      location.reload();
                    }
                }
            });   
    });



      

</script>