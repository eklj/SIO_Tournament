<?php
function h(string $valeur): string {
    return htmlspecialchars($valeur, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
