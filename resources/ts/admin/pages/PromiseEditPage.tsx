import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { PromiseRepository } from '../../repositories/PromiseRepository';
import { PromiseEditForm } from '../components/PromiseEditForm';
import { PromiseData, PromiseUpdateParams } from '../../interfaces';

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

declare const window: any;

interface PromiseEditPageData {
	promise: PromiseData;
}

interface PromiseEditPageProps {
	pageData: PromiseEditPageData;
}

interface PromiseEditPageState {
	saving: boolean;
	deleting: boolean;
}

export default class PromiseEditPage extends Component<PromiseEditPageProps, PromiseEditPageState> {
	@resolve
	promiseRepository: PromiseRepository;
	
	state: PromiseEditPageState = {
		saving: false,
		deleting: false,
	}

	constructor( props: PromiseEditPageProps ) {
		super( props );
		this.onSave = this.onSave.bind( this );
		this.onDelete = this.onDelete.bind( this );
	}

	return() {
		window.location = '/wp-admin/admin.php?page=tokenpass-vendor';
	}

	onSave( promise: PromiseUpdateParams ) {
		this.setState( { saving: true } );
		this.promiseRepository.update( this.props.pageData.promise.promise_id, promise ).then( ( result: any ) => {
			this.setState( { saving: false } );
			this.return();
		});
	}

	onDelete() {
		this.setState( { deleting: true } );
		this.promiseRepository.destroy( this.props.pageData.promise.promise_id ).then( ( result: any ) => {
			this.setState( { deleting: false } );
			this.return();
		});
	}
	
	render() {
		return (
			<Page title={'Manage promise'}>
				<div style={{marginBottom: '8px'}}>
					<a style={{display: 'inline-block'}} href='/wp-admin/admin.php?page=tokenpass-vendor'>Back to vendor</a>
					<div><span>Promise ID: </span><strong>{this.props.pageData.promise.promise_id}</strong></div>
				</div>
				<Panel>
					<PanelBody>
						<PanelRow>
							<div>
								<PromiseEditForm
									onSave={ this.onSave }
									onDelete={ this.onDelete }
									saving={this.state.saving}
									deleting={this.state.deleting}
									promise={this.props.pageData.promise}
								/>
							</div>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
