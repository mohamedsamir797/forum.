
<script>

    export default {
        props : ['data'],
      data (){
          return {
              editing : false ,
              body : this.data.body

          };
      },
        methods : {
            update(){
                axios.patch('/replies/'+ this.data.id,{
                    body : this.body
                });
                this.editing = false ;

                flash('updated!') ;
            }

        }
    }
</script>