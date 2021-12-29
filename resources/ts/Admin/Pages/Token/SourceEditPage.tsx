import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import SourceRepositoryInterface from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface';
import SourceEditForm from '../../Components/Token/SourceEditForm';
import { SourceData } from '../../../Interfaces';
import eventBus from "../../../EventBus";
import { TYPES } from '../../../Types';
import ResourceEditActions from '../../Components/ResourceEditActions';

import { 
	Panel,
	PanelBody,
	PanelRow,
	Flex,
	PanelHeader,
	Spinner,
} from '@wordpress/components';

declare const window: any;

interface SourceEditPageData {
	source: SourceData;
}

interface SourceEditPageProps {
	pageData: SourceEditPageData;
}

interface SourceEditPageState {
	id: string;
	source: any;
	editData: any;
	loading: boolean;
	saving: boolean;
	deleting: boolean;
}

export default class SourceEditPage extends Component<SourceEditPageProps, SourceEditPageState> {
	@resolve( TYPES.Repositories.Token.SourceRepositoryInterface )
	sourceRepository: SourceRepositoryInterface;
	
	state: SourceEditPageState = {
		id: null,
		source: null,
		editData: {},
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
		this.onEditDataChange = this.onEditDataChange.bind( this );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.id = urlParams.get( 'source' );
	}

	return() {
		window.location = '/wp-admin/admin.php?page=tokenly-token-source-index';
	}

	onSave() {
		this.setState( { saving: true } );
		const editData = Object.assign( {}, this.state.editData );
		this.sourceRepository.update( this.state.id, editData ).then( ( result: any ) => {
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
		this.sourceRepository.destroy( this.state.id ).then( ( result: any ) => {
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

		this.sourceRepository.show( this.state.id, params ).then( ( source: any ) => {
			if ( source.assets && Array.isArray( source.assets ) ) {
				source.assets = source.assets.join( ', ' );
			}
			const editData = Object.assign( {}, this.state.editData );
			editData.assets = source.assets;
			this.setState( {
				loading: false,
				source: source,
				editData: editData,
			} );
		} );
	}

	onEditDataChange( newData: any ) {
		this.setState( { editData: newData } );
	}
	
	render() {
		return (
			<Page title={ 'Source editor' }>
				<Panel>
					<PanelHeader>
						{ this.state.loading
						?	<Flex justify="flex-start">
								<span>Loading source ... </span>
								<Spinner />
							</Flex>
						:	<a href={ `/wp-admin/admin.php?page=tokenly-token-source-show&source=${ this.state.id }` }>{ this.state.source?.address?.label ?? this.state.id }</a>
						}
					</PanelHeader>
					<PanelBody>
						<PanelRow>
							<Flex
								//@ts-ignore
								direction="column"
							>
							{ !this.state.loading &&
								<SourceEditForm
									onChange={ this.onEditDataChange }
									loading={ this.state.loading }
									editData={ this.state.editData }
								/>
							}
								<ResourceEditActions
									name="source"
									loading={ this.state.loading }
									saving={ this.state.saving }
									deleting={ this.state.deleting }
									onSave={ this.onSave }
									onDelete={ this.onDelete }
									onCancel={ this.onCancel }
								/>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
