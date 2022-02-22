<div ng-app="peidos-app">
    <div class="page-heading" ng-controller="listController">
        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>Pedidos</h5>
                    <button type="button" class="btn bg-primary text-white" data-bs-toggle="modal" data-bs-target="#inlineForm">Add Pedido</button>
                </div>
                <div class="card-body ">
                    <div class="row colum-flex-rev">
                        <div class="col-lg-2 mb-0 pb-0">
                            <div class="mb-0  p-0 d-flex align-items-center">
                                <h6 class="mr-3">Ver </h6>
                                <select id="rowsemployes" class="form-control w-50">
                                    <option value="5" selected>5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <h6 class="ml-3">Filas</h6>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-0 pb-0">
                            <div id="allsearch" class="input-group mb-0 border border-primary rounded p-0">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                <input id="searchTrabajador" type="text" class="form-control" placeholder="Buscar..." aria-label="Recipient's username" aria-describedby="button-addon2">
                            </div>
                            <div id="smsearch" class="text-danger mb-0 pb-0"></div>
                        </div>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-hover ">
                            <thead>
                                <tr>
                                    <th class="bg-primary text-white">#</th>
                                    <th class="bg-primary text-white">Cliente</th>
                                    <th class="bg-primary text-white">Precio</th>
                                    <th class="text-white bg-primary">Pedido</th>
                                    <th class="text-white bg-primary">Fecha R</th>
                                    <th class="text-white bg-primary">Fecha E</th>
                                    <th class="text-white bg-primary">Estado</th>
                                    <th class="bg-primary text-white" style="max-width: 70px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="mostrarTrabajador">
                                <tr ng-repeat="pedido in pedidoLists">
                                    <td>{{pedido.id}}</td>
                                    <td>{{pedido.names }} {{pedido.last_name}}</td>
                                    <td>{{pedido.price}}</td>
                                    <td>{{pedido.codigo}}</td>
                                    <td>{{pedido.fecha_registro}}</td>
                                    <td>{{'-'}}</td>
                                    <td>{{pedido.estado}}</td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a class="action-icon " data-toggle="dropdown" aria-expanded="false">
                                                <svg class="svg-inline--fa fa-caret-square-down fa-w-14 fa-fw select-all" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-square-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M448 80v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zM92.5 220.5l123 123c4.7 4.7 12.3 4.7 17 0l123-123c7.6-7.6 2.2-20.5-8.5-20.5H101c-10.7 0-16.1 12.9-8.5 20.5z"></path>
                                                </svg>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item">
                                                    <i class="bi bi-pen-fill text-success"></i> Edit</a>
                                                <a class="dropdown-item"><i class="bi bi-trash m-r-5 text-danger"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h6>Total de filas <strong id="idtotal"><?= 10 ?></strong></h6>
                        {{ pedidoLists | json : spacing}}
                        <div class="card-body">
                            <nav aria-label="...">
                                <ul class="pagination" id="pagination">
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!--Add MODAL -->
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">Formulario Trabjador</h4>
                </div>
                <!-- Modal body -->
                <div class="pl-4 pr-4 pt-3">
                </div>
                <!-- Modal footer -->
                <div class="modal-footer mt-3">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Salir</button>
                    <button type="button" class="btn btn-primary" id="btnTrabajador" idtrabajador="0" editarTrabajador="NO">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>