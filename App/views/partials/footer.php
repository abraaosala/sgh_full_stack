 <footer class="pc-footer">
     <div class="footer-wrapper container-fluid">
         <div class="row">
             <div class="col-sm my-1">
                 <p class="m-0">
                     <?= $sistem ?> Desenvolvido por <a href="" target="_blank">Salab</a> .</p>
             </div>
             <div class="col-auto my-1">
                 <ul class="list-inline footer-link mb-0">
                     <li class="list-inline-item"><a href="../index.html">Home</a></li>
                     <li class="list-inline-item"><a href="https://codedthemes.gitbook.io/mantis-bootstrap"
                             target="_blank">Documentation</a></li>
                     <li class="list-inline-item"><a href="https://codedthemes.authordesk.app/"
                             target="_blank">Support</a></li>
                 </ul>
             </div>
         </div>
     </div>
 </footer>

 <!-- <script>
document.addEventListener('DOMContentLoaded', function () {
    const breadcrumb = document.querySelector('.breadcrumb');

    // Remove todos os itens exceto o primeiro ("Início")
    while (breadcrumb.children.length > 1) {
        breadcrumb.removeChild(breadcrumb.lastChild);
    }

    const path = window.location.pathname;
    const parts = path.split('/').filter(p => p !== '');

    // Ignorar a raiz (geralmente já está como "Início")
    if (parts.length > 1) {
        let fullPath = '';
        parts.slice(1).forEach((segment, index) => {
            fullPath += '/' + segment;

            // Criar elemento do breadcrumb
            const li = document.createElement('li');
            li.classList.add('breadcrumb-item');

            const nome = segment.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());

            if (index === parts.length - 2) {
                // Último item (ativo)
                li.classList.add('active');
                li.setAttribute('aria-current', 'page');
                li.textContent = nome;
            } else {
                // Link intermediário
                const a = document.createElement('a');
                a.href = fullPath;
                a.textContent = nome;
                li.appendChild(a);
            }

            breadcrumb.appendChild(li);
        });
    } else {
        // Caso queira atualizar o nome do "Dashboard" com base na página atual
        const currentPage = document.querySelector('.breadcrumb-item.active');
        if (currentPage) {
            const pageName = parts[0]?.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) || 'Dashboard';
            currentPage.textContent = pageName;
        }
    }
});
</script> -->