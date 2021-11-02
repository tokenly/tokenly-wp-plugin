import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { SourceRepository } from '../../repositories/SourceRepository';
import { SourceEditForm } from '../components/SourceEditForm';
import { SourceData } from '../../Interfaces';
import eventBus from "../../EventBus";

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
	@resolve
	sourceRepository: SourceRepository;
	
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
		window.location = '/wp-admin/admin.php?page=tokenpass-source-index';
	}

	onSave( source: SourceData ) {
		this.setState( { saving: true } );
		this.sourceRepository.update( this.props.pageData.source.address, source ).then( ( result: any ) => {
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
		this.sourceRepository.destroy( this.props.pageData.source.address ).then( ( result: any ) => {
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
			<Page title={ 'Manage source address' }>
				<div style={ { marginBottom: '8px' } }>
					<a style={ { display: 'inline-block' } } href='/wp-admin/admin.php?page=tokenpass-source-index'>Back to source list</a>
					<div><span>Address: </span><strong>{ this.props.pageData.source.address }</strong></div>
				</div>
				<Panel>
					<PanelBody>
						<PanelRow>
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
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
