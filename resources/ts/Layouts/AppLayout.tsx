import * as React from 'react';
import { useState, useEffect } from 'react';
import TcaRuleEditor from './../Admin/Components/TcaRuleEditor';
import ConfirmModal from '../Admin/Components/App/ConfirmModal';
import Snackbar from './../Admin/Components/App/Snackbar';
import { ConfirmModalData } from '../Interfaces';
import eventBus from "../EventBus";

import { 
	Fragment,
} from '@wordpress/element';

interface AppLayoutProps {
	children: any;
	pageData: any;
}

export default function AppLayout( props: AppLayoutProps ) {
	const [ confirmModalData, setConfirmModalData ] = useState<any>( null );
	const [ confirmModalShow, setConfirmModalShow ] = useState<boolean>( false );

	const [ snackbarContent, setSnackbarContent ] = useState<string>( '' );
	const [ snackbarShow, setSnackbarShow ] = useState<boolean>( false );
	const [ snackbarTimeout, setSnackbarTimeout ] = useState<any>( null );

	const [ tcaRules, setTcaRules ] = useState<any>( Object.assign( [], props?.pageData?.tca_rules ) );
	const [ postData, setPostData ] = useState<any>( {
		tca_rules: tcaRules,
	} );

	function onConfirmModalRequestClose() {
		setConfirmModalData( null );
		setConfirmModalShow( false );
	}

	function onConfirmModalChoice( choice: string ) {
		eventBus.dispatch( 'confirmModalChoice', {
			key: confirmModalData?.key,
			choice: choice,
		} );
		onConfirmModalRequestClose();
	}

	function onConfirmModalShow( newConfirmModalData: ConfirmModalData ) {
		setConfirmModalData( newConfirmModalData )
		setConfirmModalShow( true );
	}

	function onPostDataUpdated( newData: any ) {
		let state = Object.assign( {}, postData );
		state = Object.assign( state, newData );
		setPostData( state );
	}

	function onTcaUpdate( newTcaRules: any ) {
		setTcaRules( newTcaRules );
		onPostDataUpdated( {
			tca_rules: newTcaRules,
		} );
	}

	function onSnackbarShow( newSnackbarContent: string ) {
		setSnackbarContent( newSnackbarContent );
		setSnackbarShow( true );
		snackBarDebounce();
	}

	function snackBarDebounce() {
		clearTimeout( snackbarTimeout );
		setSnackbarTimeout( setTimeout(() => {
			setSnackbarShow( false );
		}, 3000) );
	}

	useEffect( () => {
		eventBus.on( 'confirmModalShow', onConfirmModalShow );
		eventBus.on( 'postDataUpdated', onPostDataUpdated );
		eventBus.on( 'snackbarShow', onSnackbarShow );
		return () => {
			eventBus.remove( 'confirmModalShow', onConfirmModalShow );
			eventBus.remove( 'snackbarShow', onSnackbarShow );
		}
	}, [] );

	return (
		<Fragment>
			{ props.children }
			{ confirmModalShow == true &&
				<ConfirmModal
					key={ confirmModalData.key }
					title={ confirmModalData.title }
					subtitle={ confirmModalData.subtitle }
					onRequestClose={ onConfirmModalRequestClose }
					onChoice={ onConfirmModalChoice }
				/>
			}
			{ props.pageData?.tca_enabled == true &&
				<TcaRuleEditor
					rules={ tcaRules }
					onChange={ onTcaUpdate }
				/>
			}
			<Snackbar show={ snackbarShow }>{ snackbarContent }</Snackbar>
			<input type="hidden" name="tokenly_data" value={ JSON.stringify( postData as any ) } />
		</Fragment>
	);
}
