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
	sourceId: string;
	source: any;
	loading: boolean;
	saving: boolean;
	deleting: boolean;
}

export default class SourceEditPage extends Component<SourceEditPageProps, SourceEditPageState> {
	@resolve( TYPES.Repositories.Token.SourceRepositoryInterface )
	sourceRepository: SourceRepositoryInterface;
	
	state: SourceEditPageState = {
		sourceId: null,
		source: null,
		loading: false,
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
		const urlParams = new URLSearchParams( window.location.search );
		this.state.sourceId = urlParams.get( 'source' );
	}

	return() {
		window.location = '/wp-admin/admin.php?page=tokenly-token-source-index';
	}

	onSave( source: SourceData ) {
		this.setState( { saving: true } );
		const sourceData = Object.assign( {}, source );
		delete sourceData.address;
		this.sourceRepository.update( this.state.sourceId, sourceData ).then( ( result: any ) => {
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

	componentWillMount() {
		this.setState( { loading: true } );
		const params = {
			with: ['address'],
		}
		this.sourceRepository.show( this.state.sourceId, params ).then( ( source: any ) => {
			if ( source.assets && Array.isArray( source.assets ) ) {
				source.assets = source.assets.join( ', ' );
			}
			this.setState( {
				loading: false,
				source: source,
			} );
		} );
	}
	
	render() {
		return (
			<Page title={ 'Manage source' }>
				<div style={ { marginBottom: '8px' } }>
					<a style={ { display: 'inline-block' } } href='/wp-admin/admin.php?page=tokenly-token-source-index'>Back to source list</a>
				</div>
				<Panel>
					<PanelBody>
						<PanelRow>
							<div>
								{ this.state.source &&
									<div>
										<span>Source: </span>
										<strong>
											<a style={ { display: 'inline-block', marginBottom: '12px' } } href={ `/wp-admin/admin.php?page=tokenly-token-source-show&source=${ this.state.sourceId }` }>{ this.state.source?.address?.label ?? this.state.sourceId }</a>
										</strong>
									</div>
								}
								<div>
									<SourceEditForm
										onSave={ this.onSave }
										onDelete={ this.onDelete }
										onCancel={ this.onCancel }
										loading={ this.state.loading }
										saving={ this.state.saving }
										deleting={ this.state.deleting }
										source={ this.state.source }
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
