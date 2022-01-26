<?php
class WPTT_Core {
    // プラグイン有効化時のデフォルトオプション
    private $wptt_default_options = array(
        'status' => 0,
        'theme' => null,
        'capabilities' => array('administrator'),
        'parameter' => 0,
        'ip_list' => null,
    );

    /**
     * 現在の設定されているテーマを取得する
     *
     * @return [str] [description]
     */
    function get_theme() {
        $options = get_option( WPTT_PLUGIN_NAME );
        if ( !empty( $options['theme'] ) ) {
            return $options['theme'];
        } else {
            return null;
        }
    }

    /**
     * テストテーマが有効化されているかどうか
     *
     * @return string | bool
     */
    function is_test_enabled() {
        $options = get_option( WPTT_PLUGIN_NAME );
        if ( $options['status'] ) {
            return true;
        }
        return false;
    }


    /**
     * 権限グループを持っているかどうか
     * @return boolean [description]
     */
    function has_capability() {
        $options = get_option( WPTT_PLUGIN_NAME );
        if(!empty($options)) if (!empty($options['capabilities']) ) {
            foreach ($options['capabilities'] as $key => $value) {
                if( current_user_can($value) ){
                    return true;
                }
            }
        }
        return false;
    }


    /**
     * 設定レベルを取得
     */
    function get_level() {
        $options = get_option( WPTT_PLUGIN_NAME );
        $level = $options['level'];

        if ( $level != '' ) {
            return 'level_' . $level;
        } else {
            return 'level_10';
        }
    }

    /**
     * 現在のパラメーターを取得
     */
    function get_parameter() {
        $options = get_option( WPTT_PLUGIN_NAME );
        if ( $options['parameter'] ) {
            return true;
        }
        return false;
    }

    /**
     * IPアドレスを取得
     */
    function get_ip_list() {
        $options = get_option( WPTT_PLUGIN_NAME );
        if ( $options['ip_list'] ) {
            return $options['ip_list'];
        }
        return false;
    }

    /**
     * 翻訳用
     */
    public function e( $text ) {
        _e( $text, WPTT_TEXT_DOMAIN );
    }

    public function _( $text ) {
        return __( $text, WPTT_TEXT_DOMAIN );
    }

    /**
     * プラグインが有効化されたときに実行
     */
    function activation_hook() {
        if ( !get_option( WPTT_PLUGIN_NAME ) ) {
            update_option( WPTT_PLUGIN_NAME, $this->wptt_default_options );
        }
    }

    /**
     * 無効化ときに実行
     */
    function deactivation_hook() {
        delete_option( WPTT_PLUGIN_NAME );
    }

    /**
     * アンインストール時に実行
     */
    function uninstall_hook() {
        delete_option( WPTT_PLUGIN_NAME );
    }
}
