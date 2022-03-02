import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import ConfirmModal from '../../Admin/Components/App/ConfirmModal';
import Snackbar from './../../Admin/Components/App/Snackbar';
import { ConfirmModalData } from '../../Interfaces';
import eventBus from "../../EventBus";
import { TYPES } from '../../Types';

import { 
	Fragment,
} from '@wordpress/element';

interface AppLayoutProps {
	page: any;
}

export default function AppLayout( props: AppLayoutProps ) {
	const namespace: string = useInjection( TYPES.Variables.namespace );

	const [ confirmModalData, setConfirmModalData ] = useState<any>( null );
	const [ confirmModalShow, setConfirmModalShow ] = useState<boolean>( false );

	const [ snackbarContent, setSnackbarContent ] = useState<string>( '' );
	const [ snackbarShow, setSnackbarShow ] = useState<boolean>( false );
	const [ snackbarTimeout, setSnackbarTimeout ] = useState<any>( null );
	const [ postData, setPostData ] = useState<any>( null );

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
		eventBus.on( 'snackbarShow', onSnackbarShow );
		return () => {
			eventBus.remove( 'confirmModalShow', onConfirmModalShow );
			eventBus.remove( 'snackbarShow', onSnackbarShow );
		}
	}, [] );

	return (
		<Fragment>
			{ React.cloneElement( props.page, { onPostDataChange: onPostDataUpdated } ) }
		{ confirmModalShow == true &&
			<ConfirmModal
				key={ confirmModalData?.key }
				title={ confirmModalData?.title }
				subtitle={ confirmModalData?.subtitle }
				onRequestClose={ onConfirmModalRequestClose }
				onChoice={ onConfirmModalChoice }
			/>
		}
			<Snackbar show={ snackbarShow }>{ snackbarContent }</Snackbar>
			<input type="hidden" name={ `${namespace}_data` } value={ JSON.stringify( postData ) } />
		</Fragment>
	);
}
