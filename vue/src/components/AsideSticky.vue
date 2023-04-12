<template>
    <div class="aside-sticky-block">
        <slot></slot>
    </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
    name: 'AsideSticky',
    components: {
    },
    props: {
        marginTop: {
            default() {
                return 24;
            },
        },
        marginBottom: {
            default() {
                return 24;
            },
        },

    },
    data() {
        return {
            aside: null,
            newBlock: null,
            fixedMargin: null,
            z: null,
        };
    },
    computed: {
        ...mapState({
            isDesktop: (state) => state.isDesktop,
        }),
    },
    mounted() {
        if (this.isDesktop) {
            setTimeout(() => {
                const aside = document.querySelector('.aside');
                this.aside = aside || '';
                window.addEventListener('scroll', this.ascroll, false);
                window.addEventListener('resize', this.ascroll, false);
            }, 100);
        }
    },
    beforeUnmount() {
        this.aside = '';
        window.removeEventListener('scroll', this.ascroll, false);
        window.removeEventListener('resize', this.ascroll, false);
    },
    watch: {
        $route() {
            if (this.newBlock) {
                this.newBlock.className = '';
                this.newBlock.style.top = '0px';
            }
        },
    },
    methods: {
        ascroll() {
            if (document.querySelector('.container-scroll') && this.aside) {
                const Ra = this.aside.getBoundingClientRect();
                const R1bottom = document.querySelector('.container-scroll').getBoundingClientRect().bottom;
                if (Ra.bottom < R1bottom) {
                    if (this.newBlock === null) {
                        const Sa = getComputedStyle(this.aside, ''); let
                            s = '';
                        for (let i = 0; i < Sa.length; i += 1) {
                            if (Sa[i].indexOf('overflow') === 0 || Sa[i].indexOf('padding') === 0 || Sa[i].indexOf('border') === 0 || Sa[i].indexOf('outline') === 0 || Sa[i].indexOf('box-shadow') === 0 || Sa[i].indexOf('background') === 0) {
                                s += `${Sa[i]}: ${Sa.getPropertyValue(Sa[i])}; `;
                            }
                        }
                        this.newBlock = document.createElement('div');
                        this.newBlock.className = '';
                        this.newBlock.style.cssText = `${s} box-sizing: border-box; width: ${this.aside.offsetWidth}px;`;
                        this.aside.insertBefore(this.newBlock, this.aside.firstChild);
                        const l = this.aside.childNodes.length;
                        for (let i = 1; i < l; i += 1) {
                            this.newBlock.appendChild(this.aside.childNodes[1]);
                        }
                    }
                    const Rb = this.newBlock.getBoundingClientRect();
                    const Rh = Ra.top + Rb.height;
                    const W = document.documentElement.clientHeight;
                    const R1 = Math.round(Rh - R1bottom);
                    const R2 = Math.round(Rh - W);
                    if (Rb.height > W) {
                        if (Ra.top < this.fixedMargin) { // скролл вниз
                            if (R2 + this.marginBottom > R1) { // не дойти до низа
                                if (Math.floor(Rb.bottom - W + this.marginBottom) <= 0) { // подцепиться
                                    this.newBlock.className = 'sticky';
                                    this.newBlock.style.top = `${W - Rb.height - this.marginBottom}px`;
                                    this.z = this.marginBottom + Ra.top + Rb.height - W;
                                } else {
                                    this.newBlock.className = 'stop';
                                    this.newBlock.style.top = `${-this.z}px`;
                                }
                            } else {
                                this.newBlock.className = 'stop';
                                this.newBlock.style.top = `${-R1}px`;
                                this.z = R1;
                            }
                        } else if (Ra.top - this.marginTop < 0) { // не дойти до верха
                            if (Rb.top - this.marginTop >= 0) { // подцепиться
                                this.newBlock.className = 'sticky';
                                this.newBlock.style.top = `${this.marginTop}px`;
                                this.z = Ra.top - this.marginTop;
                            } else {
                                this.newBlock.className = 'stop';
                                this.newBlock.style.top = `${-this.z}px`;
                            }
                        } else {
                            this.newBlock.className = '';
                            this.newBlock.style.top = '';
                            this.z = 0;
                        }
                        this.fixedMargin = Ra.top;
                    } else if ((Ra.top - this.marginTop) <= 0) {
                        if ((Ra.top - this.marginTop) <= R1) {
                            this.newBlock.className = 'stop';
                            this.newBlock.style.top = `${-R1}px`;
                        } else {
                            this.newBlock.className = 'sticky';
                            this.newBlock.style.top = `${this.marginTop}px`;
                        }
                    } else {
                        this.newBlock.className = '';
                        this.newBlock.style.top = '';
                    }
                }
            }
        },
    },
};
</script>

<style lang="sass">
$aside-width: 392px
.aside-sticky-block
    width: 296px
    +for-size(992)
        width: $aside-width
    .aside
        width: 296px
        flex: 0 1 auto
        position: relative
        z-index: 3
        +for-size(992)
            width: $aside-width
            min-width: $aside-width
        .sticky
            position: fixed
            z-index: 4
        .stop
          position: absolute
</style>
