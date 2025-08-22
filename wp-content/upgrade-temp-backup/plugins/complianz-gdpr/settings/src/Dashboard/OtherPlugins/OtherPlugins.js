import { useEffect} from "@wordpress/element";
import { __ } from '@wordpress/i18n';
import Placeholder from '../../Placeholder/Placeholder';
import useOtherPlugins  from "./OtherPluginsData";
const OtherPlugins = () => {
    const {dataLoaded, pluginData, pluginActions, fetchOtherPluginsData, error} = useOtherPlugins();
    useEffect(() => {
        if (!dataLoaded) {
            fetchOtherPluginsData();
        }
    }, [] )

    const otherPluginElement = (plugin, i) => {
        return (
           <div key={i} className={"cmplz-other-plugins-element cmplz-"+plugin.slug}>
			   <a href={plugin.wordpress_url} target="_blank" rel="noopener noreferrer" title={plugin.title}>
                   <div className="cmplz-bullet"></div>
                   <div className="cmplz-other-plugins-content">{plugin.title}</div>
               </a>
               <div className="cmplz-other-plugin-status">
				   {plugin.pluginAction==='upgrade-to-premium' && <a target="_blank" href={plugin.upgrade_url} rel="noopener noreferrer">{__("Upgrade", "complianz-gdpr")}</a>}
                	{plugin.pluginAction!=='upgrade-to-premium' && plugin.pluginAction!=='installed' &&
                    <a href="#" onClick={ (e) => pluginActions(plugin.slug, plugin.pluginAction, e) } >{plugin.pluginActionNice}</a>}
                	{plugin.pluginAction==='installed' && __("Installed", "complianz-gdpr")}
               </div>
           </div>
        )
    }

    if ( !dataLoaded || error) {
        return (<Placeholder lines="3" error={error}></Placeholder>)
    }

    return (
           <div className="cmplz-other-plugins-container">
               { pluginData.map((plugin, i) => otherPluginElement(plugin, i)) }
           </div>
    )
}

export default OtherPlugins;
