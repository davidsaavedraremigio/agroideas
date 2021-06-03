
<div class="row">
    <!-- Primer Cuadro -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Nº de incentivos</span>
                    <span class="info-box-number">{{number_format($data->nro_sp)}}</span>
                </div>
            </div>
        </div>

        <!-- Segundo Cuadro -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-coins"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Inversión PCC (S/)</span>
                    <span class="info-box-number">{{number_format($data->pcc,0)}}</span>
                </div>
            </div>
        </div>

        <div class="clearfix hidden-md-up"></div>

        <!-- Tercer Cuadro -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-coins"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Contrapartida (S/)</span>
                    <span class="info-box-number">{{number_format($data->contrapartida,0)}}</span>
                </div>
            </div>
        </div>
        <!-- Cuarto Cuadro -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-chart-line"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Nivel de ejecución</span>
                    <span class="info-box-number">{{number_format($data->avance,0)}}<small>%</small></span>
                </div>
            </div>
        </div>
</div>