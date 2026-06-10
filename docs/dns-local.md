# Evidencia de DNS local - Solutec

Para a sprint, a evidencia pedida na rubrica deve ser um print de tela do arquivo `hosts` do Windows com o dominio local configurado.

Arquivo:

```txt
C:\Windows\System32\drivers\etc\hosts
```

Linha sugerida para adicionar:

```txt
127.0.0.1    solutec.local
```

Depois de salvar como administrador, acesse:

```txt
http://solutec.local
```

Se estiver usando o servidor embutido do PHP para apresentacao, use:

```txt
php -S solutec.local:8000
```

E acesse:

```txt
http://solutec.local:8000
```

O print deve mostrar o arquivo `hosts` aberto e a linha `127.0.0.1    solutec.local` visivel.
