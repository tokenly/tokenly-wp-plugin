import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import SourceRepositoryInterface from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface';
import SourceEditForm from '../../Components/Token/SourceEditForm';
import { SourceData } from '../../../Interfaces';
import eventBus from "../../../EventBus";
import { TYPES } from '../../../Types';

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

declare const window: any;

interface SourceEditPageData {
	source: SourceData;
}

interface SourceEditPageProps {
	pageData: SourceEditPageData;
}

interface SourceEditPageState {
	saving: boolean;
	deleting: boolean;
}

export default class SourceEditPage extends Component<SourceEditPageProps, SourceEditPageState> {
	@resolve( TYPES.Repositories.Token.SourceRepositoryInterface )
	sourceRepository: SourceRepositoryInterface;
	
	state: SourceEditPageState = {
		saving: false,
		deleting: false,
	}

	constructor( props: SourceEditPageProps ) {
		super( props );
		this.onSave = this.onSave.bind( this );
		this.onDelete = this.onDelete.bind( this );
		this.onCancel = this.onCancel.bind( this );
		this.deleteSource = this.deleteSource.bind( this );
		this.onConfirmModalChoice = this.onConfirmModalChoice.bind( this );
	}

	return() {
		window.location = '/wp-admin/admin.php?page=tokenly-token-source-index';
	}

	onSave( source: SourceData ) {
		this.setState( { saving: true } );
		const sourceData = Object.assign( {}, source );
		delete sourceData.address;
		this.sourceRepository.update( this.props.pageData.source.address_id, sourceData ).then( ( result: any ) => {
			this.setState( { saving: false } );
			this.return();
		});
	}

	onDelete() {
		eventBus.dispatch( 'confirmModalShow', {
			key: 'sourceDelete',
			title: 'Deleting source',
			subtitle: 'Are you sure you want to delete the source?',
		});
	}

	onCancel() {
		this.return();
	}

	deleteSource() {
		this.setState( { deleting: true } );
		this.sourceRepository.destroy( this.props.pageData.source.address_id ).then( ( result: any ) => {
			this.setState( { deleting: false } );
			this.return();
		});
	}

	onConfirmModalChoice( payload: any ) {
		switch( payload.key ) {
			case 'sourceDelete':
				if ( payload.choice == 'accept' ){
					this.deleteSource();
				}
				break;
		}
	}

	componentDidMount() {
		eventBus.on( 'confirmModalChoice', this.onConfirmModalChoice );
	}
	
	componentWillUnmount() {
		eventBus.remove( 'confirmModalChoice', this.onConfirmModalChoice );
	}
	
	render() {
		const source = Object.assign( {}, this.props.pageData.source ) as any;
		if ( source?.assets?.length ) {
			source.assets = source.assets.join( ', ' );
		}		
		return (
			<Page title={ 'Manage source' }>
				<div style={ { marginBottom: '8px' } }>
					<a style={ { display: 'inline-block' } } href='/wp-admin/admin.php?page=tokenly-token-source-index'>Back to source list</a>
				</div>
				<Panel>
					<PanelBody>
						<PanelRow>
							<div>
								<div><span>Source: </span><strong>
									<a style={ { display: 'inline-block', marginBottom: '12px' } } href={ `/wp-admin/admin.php?page=tokenly-token-source-show&source=${ source.address_id }` }>{ source?.address?.label }</a>
								</strong></div>
								<div>
									<SourceEditForm
										onSave={ this.onSave }
										onDelete={ this.onDelete }
										onCancel={ this.onCancel }
										saving={ this.state.saving }
										deleting={ this.state.deleting }
										sourceData={ source }
									/>
								</div>
							</div>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
