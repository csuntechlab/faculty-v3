<template>
    <span data-toggle="tooltip" :data-placement="tooltipPlacement" :title="tooltipContent">
        <slot></slot>
    </span>
</template>

<script>
export default {
    name: 'tooltip',
    props: {
        tooltipContent:String,
        tooltipPlacement:{
            type:String,
            default:'auto'
        },
        destroyOnXSBreakpoint: {
            type:Boolean,
            default:false
        }
    },
    data() {
        return {
            windowWidth: window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth
        }
    },
    methods: {
        initTooltip: function() {
            $(this.$el).tooltip({ boundary: 'window' });
        },
        destroyTooltop: function() {
            $(this.$el).tooltip('dispose');
        }
    },
    mounted() {     
        if( this.$options.propsData.destroyOnXSBreakpoint == true ) {
            if( this.windowWidth > 575 ) {
                this.initTooltip();
            }
        } else {
            this.initTooltip();
        }
    },
    beforeDestroy: function() {
        this.destroyTooltop();
    }
}
</script>