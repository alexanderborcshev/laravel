<template>
    <div class="content docs">
        <div class="links">
            <div class="inner">
                <a href="#icons">ИКОНКИ</a>
                <a href="#inputs">ИНПУТ</a>
                <a href="#textarea">ТЕКСТАЕРА</a>
                <a href="#buttons">кнопки</a>
            </div>
        </div>
        <div class="block" id="icons">
            <div class="text-size-32 text-bold mb48 ttl"><a href="#icons">#</a>ИКОНКИ</div>
            <div class="icons">
                <div class="icon-block" @click="copy(icon)" v-for="icon in iconsList" :key="icon">
                    <div class="copy">
                        copy
                    </div>
                    <div class="icon">
                        <svg-icon :name="`${icon}`" :width="30" :height="30"></svg-icon>
                    </div>
                    <div class="text-size-10 text-color-gray50 icon-name mt8">{{icon}}</div>
                </div>
            </div>
        </div>
        <div class="block" id="inputs">
            <div class="text-size-32 text-bold mb48 ttl"><a href="#inputs">#</a>ИНПУТ</div>
            <div class="">
                <div class="df">
                    <input-styled
                            name="name"
                            :placeholderInput="'Плейсхолдер'"
                            v-model="input"
                            :is-error="false">
                    </input-styled>
                    <input-styled
                            name="name"
                            :placeholderInput="'Плейсхолдер'"
                            v-model="inputFill"
                            :is-error="false">
                    </input-styled>
                    <input-styled
                            name="name"
                            :placeholderInput="'Плейсхолдер'"
                            v-model="input"
                            :is-error="true">
                    </input-styled>
                </div>
                <code>
<pre>&lt;input-styled
     name=&quot;&quot;
     :class=&quot;&#39;&#39;&quot;
     :placeholderInput=&quot;&#39;Плейсхолдер&#39;&quot;
     @blur=&quot;блюр&quot;
     v-model=&quot;&quot;
     @focus=&quot;&quot;
     :is-error=&quot;&quot;
     :errorText=&quot;текст ошибки&quot;&gt;
 &lt;/input-styled&gt;</pre>
                </code>
            </div>
        </div>
        <div class="block" id="textarea">
            <div class="text-size-32 text-bold mb48 ttl"><a href="#textarea">#</a>ТЕКСТАРЕА</div>
            <div class="">
                <div class="df">
                    <textarea-field
                            v-model="textarea"
                            :is-error="false"
                            class="full"
                            :error-text="''"
                            :auto-focus="true"
                            placeholder="Плейсхолдер"
                            :add-style="{minHeight: isDesktop ? 88 + 'px' : 96 + 'px'}">
                    </textarea-field>
                    <textarea-field
                            v-model="textareaFill"
                            :is-error="false"
                            class="full"
                            :error-text="''"
                            :auto-focus="true"
                            placeholder="Плейсхолдер"
                            :add-style="{minHeight: isDesktop ? 88 + 'px' : 96 + 'px'}">
                    </textarea-field>
                    <textarea-field
                            v-model="textarea"
                            :is-error="true"
                            class="full"
                            :error-text="''"
                            :auto-focus="true"
                            placeholder="Плейсхолдер"
                            :add-style="{minHeight: isDesktop ? 88 + 'px' : 96 + 'px'}">
                    </textarea-field>
                </div>
                <code>
<pre>&lt;textarea-field :class=&quot;&#39;&#39;&quot;
  v-model=&quot;&quot;
  :is-error=&quot;&quot;
  :error-text=&quot;&#39;текст ошибки&#39;&quot;
  :auto-focus=&quot;&quot;
  placeholder=&quot;Плейсхолдер&quot;
  :add-style=&quot;{minHeight: 100 + &#39;px&#39;}&quot;&gt;
&lt;/textarea-field&gt;</pre>
                </code>
            </div>
        </div>
        <div class="block" id="buttons">
            <div class="text-size-32 text-bold mb48 ttl"><a href="#buttons">#</a>КНОПКИ</div>
            <div class="">
                <div class="df">
                    <submit-btn :type="'normal'" tag="button" class="btn">
                        подтвердить
                    </submit-btn>
                    <submit-btn :type="'load'" tag="button" class="btn">
                        подтвердить
                    </submit-btn>
                    <submit-btn :type="'normal'" tag="button" class="btn btn--green">
                        подтвердить
                    </submit-btn>
                    <submit-btn :type="'normal'" tag="button" class="btn btn--red">
                        подтвердить
                    </submit-btn>
                    <submit-btn :type="'normal'" tag="button" class="btn btn--mini">
                        подтвердить
                    </submit-btn>
                </div>
                <code>
<pre>&lt;submit-btn @click=&quot;sendForm&quot; class=&quot;btn mr24&quot; :type=&quot;btnType&quot;&gt;
  &lt;svg-icon :name=&quot;&#39;check&#39;&quot; :width=&quot;16&quot; :height=&quot;16&quot; class=&quot;mr4&quot;&gt;&lt;/svg-icon&gt;
  Подтвердить
&lt;/submit-btn&gt;</pre>
                </code>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import SvgIcon from '@/components/SvgIcon.vue';
import { copyTextToClipboard } from '@/helpers/util/helper';
import icons from '@/assets/icons';
import InputStyled from '@/components/forms/InputStyled.vue';
import TextareaField from '@/components/forms/TextareaField.vue';
import SubmitBtn from '@/components/forms/SubmitBtn.vue';

export default {
    name: 'UiBoard',
    components: {
        SvgIcon,
        InputStyled,
        TextareaField,
        SubmitBtn,
    },
    props: {
    },
    data() {
        return {
            iconsList: [],
            input: '',
            inputFill: 'Заполнено',
            textarea: '',
            textareaFill: 'Заполнено',
        };
    },
    mounted() {
        this.iconsList = icons.sort();
    },
    computed: {
        ...mapState({
            popups: (state) => state.popups.items,
            switches: (state) => state.switches.items,
        }),
    },
    methods: {
        copy(name) {
            copyTextToClipboard(name);
        },
    },
};
</script>

<style lang="sass">
.docs
    width: 900px
    margin: 0 auto
    padding-top: 0px
    padding-bottom: 100px
    background-color: #fff
    .links
        height: 48px
        position: fixed
        top: 56px
        background-color: #212121
        z-index: 10
        width: 100%
        left: 0
        right: 0
        .inner
            width: 900px
            margin: 0 auto
            display: flex
            align-items: center
            gap: 20px
            height: 100%
        a
            text-transform: uppercase
            font-size: 16px
            color: #fff
            font-weight: bold
            transition: all .15s ease
            &:hover
                color: #ffc700
    .block
        padding-top: 115px
        padding-bottom: 0
        position: relative
        &:last-child
            &:after
                content: none
        .df
            gap: 30px
            margin-bottom: 32px
        &:after
            content: ''
            position: absolute
            width: 100%
            height: 1px
            background-color: #ececec
            bottom: -56px
    .ttl
        margin-left: 0
        a
            color: $green
            margin-right: 12px
    code
        padding: 16px
        background-color: #292d3e
        color: #ececec
        display: block
        font-size: 16px
        line-height: 22px
        border-radius: 10px
.icons
    display: flex
    flex-wrap: wrap
    width: 100%
    padding-bottom: 0
    .icon-block
        margin-right: 16px
        margin-bottom: 16px
        width: 64px
        height: 70px
        border: 1px solid $gray20
        border-radius: 4px
        display: flex
        flex-direction: column
        align-items: center
        justify-content: center
        box-shadow: 0px 0px 5px rgba(#000, 0.05)
        transition: all .25s ease
        cursor: pointer
        position: relative
        &:hover
            transform: scale(1.05)
            .copy
                opacity: 1
        .icon
            width: 30px
            height: 30px
            display: flex
            align-items: center
            justify-content: center
            svg
                width: 100%
                height: 100%
        .icon-name
            margin-bottom: -10px
        .copy
            position: absolute
            opacity: 0
            width: 100%
            height: 100%
            top: 0
            left: 0
            display: flex
            transition: all .25s ease
            align-items: center
            justify-content: center
            background-color: rgba(#fff, 0.85)
            border-radius: 4px

</style>
