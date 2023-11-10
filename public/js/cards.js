const btns = document.querySelectorAll('.del-character')
btns.forEach(el=>{
    el.addEventListener('click',e=>{
        const id = e.target.dataset.id
        axios({
            url:'/delete-character/'+id,
            method:'DELETE',
        }).then(res=>{
            console.log(res.status )
            if(res.status  === 200){
                alertify.success('Se ha eliminado el personaje')
                setTimeout(()=>{
                    window.location.reload()
                },1500)
            }
        }).catch(err=>{
            alertify.error(err.response.data.message)
        })
    })
})
