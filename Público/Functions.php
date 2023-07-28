<?php
namespace App;

class Functions {
    // Função para validar CPF
    public static function validaCPF($cpf) {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Verifica se o CPF tem 11 caracteres
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/^([0-9])\1+$/', $cpf)) {
            return false;
        }

        // Calcula os dígitos verificadores
        for ($i = 9; $i < 11; $i++) {
            $j = 0;
            for ($k = 0; $k < $i; $k++) {
                $j += $cpf[$k] * (($i + 1) - $k);
            }
            $j = (($j % 11) < 2) ? 0 : (11 - ($j % 11));
            if ($cpf[$i] != $j) {
                return false;
            }
        }

        return true;
    }

    // Função para validar e-mail
    public static function validaEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    // Função para sanitizar inputs de usuário
    public static function sanitize($input) {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }
}
