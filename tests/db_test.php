<?php
use App\Models\Paciente;
dd(Paciente::with(['usuario'])->get());