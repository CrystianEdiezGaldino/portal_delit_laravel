<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- CSS necessários -->
<link href='https://cdn.jsdelivr.net/npm/@fullcalendar/core@5.11.3/main.min.css' rel='stylesheet' />
<link href='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@5.11.3/main.min.css' rel='stylesheet' />
<link href='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@5.11.3/main.min.css' rel='stylesheet' />
<link href='https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@5.11.3/main.min.css' rel='stylesheet' />

<!-- JavaScript necessários -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    var base_url = "<?php echo base_url(); ?>";
</script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@5.11.3/main.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/locales@5.11.3/pt-br.js"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Calendário de Eventos</h4>
                    <button class="btn btn-primary" id="btnNovoEvento">
                        <i class="fas fa-plus"></i> Novo Evento
                    </button>
                </div>
                <div class="card-body">
                    <div id="calendar" style="min-height: 800px;"></div> <!-- Ensure the calendar has a minimum height -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Criar/Editar Evento -->
<div class="modal fade" id="eventoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Gerenciar Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="eventoForm">
                    <input type="hidden" id="eventoId">
                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Início</label>
                        <input type="datetime-local" class="form-control" id="inicio" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fim</label>
                        <input type="datetime-local" class="form-control" id="fim" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cor</label>
                        <input type="color" class="form-control" id="cor" value="#3788d8">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnExcluir">Excluir</button>
                <button type="button" class="btn btn-primary" id="btnSalvar">Salvar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    
    // Ensure FullCalendar is properly initialized
    if (typeof FullCalendar !== 'undefined') {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            themeSystem: 'bootstrap5',
            locale: 'pt-br',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            initialView: 'dayGridMonth',
            height: 'auto', // Ensure the calendar adjusts to the container
            navLinks: true,
            selectable: true,
            selectMirror: true,
            editable: true,
            dayMaxEvents: true,
            events: function(info, successCallback, failureCallback) {
                $.ajax({
                    url: base_url + 'calendario/getEventos',
                    method: 'GET',
                    success: function(response) {
                        var eventos = JSON.parse(response);
                        successCallback(eventos);
                        
                        // Verifica se não há eventos e mostra alerta
                        if (eventos.length === 0) {
                            Swal.fire({
                                title: 'Nenhum evento cadastrado',
                                text: 'O calendário está vazio no momento',
                                icon: 'info',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        }
                    },
                    error: function() {
                        Swal.fire('Erro!', 'Erro ao carregar eventos', 'error');
                        failureCallback();
                    }
                });
            },
            
            select: function(info) {
                $('#eventoId').val('');
                $('#titulo').val('');
                $('#inicio').val(moment(info.start).format('YYYY-MM-DDTHH:mm'));
                $('#fim').val(moment(info.end).format('YYYY-MM-DDTHH:mm'));
                $('#descricao').val('');
                $('#cor').val('#3788d8');
                $('#btnExcluir').hide();
                $('#eventoModal').modal('show');
            },
    
            eventClick: function(info) {
                $('#eventoId').val(info.event.id);
                $('#titulo').val(info.event.title);
                $('#inicio').val(moment(info.event.start).format('YYYY-MM-DDTHH:mm'));
                $('#fim').val(moment(info.event.end).format('YYYY-MM-DDTHH:mm'));
                $('#descricao').val(info.event.extendedProps.description);
                $('#cor').val(info.event.backgroundColor);
                $('#btnExcluir').show();
                $('#eventoModal').modal('show');
            },
    
            eventDrop: function(info) {
                atualizarEvento(info.event);
            },
    
            eventResize: function(info) {
                atualizarEvento(info.event);
            }
        });
        calendar.render();
    } else {
        console.error('FullCalendar library failed to load');
    }
});

    // Funções do Modal
    $('#btnSalvar').click(function() {
        var dados = {
            id: $('#eventoId').val(),
            title: $('#titulo').val(),
            start: $('#inicio').val(),
            end: $('#fim').val(),
            description: $('#descricao').val(),
            backgroundColor: $('#cor').val()
        };

        $.ajax({
            url: base_url + 'calendario/salvarEvento',
            method: 'POST',
            data: dados,
            success: function(response) {
                $('#eventoModal').modal('hide');
                calendar.refetchEvents();
                Swal.fire('Sucesso!', 'Evento salvo com sucesso!', 'success');
            },
            error: function() {
                Swal.fire('Erro!', 'Erro ao salvar evento', 'error');
            }
        });
    });

    $('#btnExcluir').click(function() {
        Swal.fire({
            title: 'Confirmar exclusão?',
            text: "Esta ação não poderá ser revertida!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + 'calendario/excluirEvento',
                    method: 'POST',
                    data: { id: $('#eventoId').val() },
                    success: function() {
                        $('#eventoModal').modal('hide');
                        calendar.refetchEvents();
                        Swal.fire('Excluído!', 'Evento excluído com sucesso.', 'success');
                    },
                    error: function() {
                        Swal.fire('Erro!', 'Erro ao excluir evento', 'error');
                    }
                });
            }
        });
    });

    function atualizarEvento(evento) {
        $.ajax({
            url: base_url + 'calendario/atualizarEvento',
            method: 'POST',
            data: {
                id: evento.id,
                start: moment(evento.start).format('YYYY-MM-DD HH:mm:ss'),
                end: moment(evento.end).format('YYYY-MM-DD HH:mm:ss')
            },
            success: function() {
                calendar.refetchEvents();
            },
            error: function() {
                Swal.fire('Erro!', 'Erro ao atualizar evento', 'error');
                calendar.refetchEvents();
            }
        });
    }
});
</script>
