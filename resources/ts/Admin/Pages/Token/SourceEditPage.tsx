import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import Page from './../Page';
import SourceRepositoryInterface from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface';
import SourceEditForm from '../../Components/Token/SourceEditForm';
import { TYPES } from '../../Types';
import Preloader from '../../Components/Preloader';
import SourceLink from '../../Components/Token/SourceLink';
import ResourceEditActions from '../../Components/ResourceEditActions';

import { 
	Panel,
	PanelBody,
	PanelRow,
	PanelHeader,
} from '@wordpress/components';

declare const window: any;

interface SourceEditPageProps {
	//
}

export default function SourceEditPage( props: SourceEditPageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const sourceRepository: SourceRepositoryInterface = useInjection( TYPES.Repositories.Token.SourceRepositoryInterface );
	
	const urlParams = new URLSearchParams( window.location.search );

	const [ id, setId ] = useState<string>( urlParams.get( 'source' ) );
	const [ source, setSource ] = useState<any>( null );
	const [ editData, setEditData ] = useState<any>( {} );
	const [ loading, setLoading ] = useState<boolean>( false );
	const [ saving, setSaving ] = useState<boolean>( false );

	function goBack() {
		window.location = `${adminPageUrl}${namespace}-token-source-index`;
	}

	function onSave() {
		setSaving( true );
		const newEditData = Object.assign( {}, editData );
		sourceRepository.update( id, newEditData ).then( ( result: any ) => {
			setSaving( false );
			goBack();
		} );
	}

	useEffect( () => {
		setLoading( true );
		const params = {
			with: ['address'],
		}
		sourceRepository.show( id, params ).then( ( sourceFound: any ) => {
			if ( sourceFound.assets && Array.isArray( sourceFound.assets ) ) {
				sourceFound.assets = sourceFound.assets.join( ', ' );
			}
			const newEditData = Object.assign( {}, editData );
			newEditData.assets = sourceFound.assets;
			setLoading( false );
			setSource( sourceFound );
			setEditData( newEditData );
		} );
	}, [] );

	function onEditDataChange( newData: any ) {
		setEditData( newData );
	}

	return (
		<Page title="Source Editor">
			<Panel>
				<PanelHeader>
					<Preloader loading={ loading }>
						Source Edit Form
					</Preloader>
				</PanelHeader>
			{ ( !loading && source ) &&
				<PanelBody>
					<PanelRow>
						<div>
							<span>Source: </span>
							<b>
								<SourceLink id={ id } label={ source?.address?.label } />
							</b>
						</div>
					</PanelRow>
					<PanelRow>
						<SourceEditForm
							onChange={ onEditDataChange }
							loading={ loading }
							editData={ editData }
						/>
					</PanelRow>
				</PanelBody>
			}
			</Panel>
			<Panel>
				<PanelBody>
					<PanelRow>
						<ResourceEditActions
							name="Source"
							saving={ saving }
							onSave={ onSave }
							noDelete
							onCancel={ () => {
								goBack();
							} }
						/>
					</PanelRow>
				</PanelBody>
			</Panel>
		</Page>
	);
}
